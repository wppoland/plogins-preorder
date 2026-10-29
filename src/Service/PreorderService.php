<?php

declare(strict_types=1);

namespace Preorder\Service;

defined('ABSPATH') || exit;

use Preorder\Contract\HasHooks;
use Preorder\ProductMeta;
use Preorder\Settings;

/**
 * Storefront behaviour for pre-order products.
 *
 * When a product is flagged as a pre-order it becomes purchasable even while out
 * of stock, the add-to-cart button label changes, and the cart line + order line
 * are flagged as pre-orders for fulfilment.
 *
 * Everything degrades gracefully: if the plugin is globally disabled, the product
 * is not a pre-order, or WooCommerce data is missing, the methods short-circuit
 * and leave the default storefront behaviour untouched.
 */
final class PreorderService implements HasHooks
{
    private const CART_FLAG     = 'preorder_is_preorder';
    private const ORDER_LINE_KEY = '_preorder_line';

    public function __construct(
        private readonly Settings $settings,
        private readonly ProductMeta $meta,
    ) {
    }

    public function registerHooks(): void
    {
        if (! $this->settings->isEnabled()) {
            return;
        }

        // Make pre-order products purchasable while out of stock.
        add_filter('woocommerce_is_purchasable', [$this, 'filterPurchasable'], 10, 2);
        add_filter('woocommerce_product_is_in_stock', [$this, 'filterInStock'], 10, 2);
        add_filter('woocommerce_product_backorders_allowed', [$this, 'filterBackordersAllowed'], 10, 2);

        // Change the add-to-cart button label.
        add_filter('woocommerce_product_single_add_to_cart_text', [$this, 'filterButtonText'], 10, 2);
        add_filter('woocommerce_product_add_to_cart_text', [$this, 'filterButtonText'], 10, 2);

        // Per-variation pre-order data for the variations form.
        add_filter('woocommerce_available_variation', [$this, 'addVariationData'], 10, 3);

        // Storefront: show the reservation stub on the single product page.
        add_action('woocommerce_single_product_summary', [$this, 'renderStub'], 25);
        add_action('wp_enqueue_scripts', [$this, 'enqueueAssets']);

        // Flag the cart item, surface it in the cart/checkout, and copy to the order.
        add_filter('woocommerce_add_cart_item_data', [$this, 'addCartItemData'], 10, 3);
        add_filter('woocommerce_get_item_data', [$this, 'displayCartItemData'], 10, 2);
        add_action('woocommerce_checkout_create_order_line_item', [$this, 'addOrderItemMeta'], 10, 4);

        // Partner plugins. Each filter only runs when its plugin is active.
        // Waitlist: a pre-order already has its own button, no "Notify me" beside it.
        add_filter('plogins_waitlist_accepts_subscriptions', [$this, 'filterWaitlistAccepts'], 10, 2);
        // Klepsidro: count down to the release date instead of asking for it twice.
        add_filter('ticker/end_timestamp', [$this, 'filterCountdownEnd'], 10, 2);
        add_filter('ticker/template/args', [$this, 'filterCountdownArgs'], 10, 2);
    }

    /**
     * Take a pre-order product or variation off the Waitlist.
     *
     * A variable parent passes through: the waitlist asks again per variation,
     * so a product mixing pre-order and in-stock variations keeps the form for
     * the ones that are simply out of stock.
     */
    public function filterWaitlistAccepts(bool $accepts, mixed $product): bool
    {
        if (! $accepts || ! $product instanceof \WC_Product || $product->is_type('variable')) {
            return $accepts;
        }

        return ! $this->applies($product);
    }

    /**
     * Klepsidro end time: the pre-order release date when one is still ahead.
     *
     * The release date wins over a sale end or a campaign date, since it is
     * the date a shopper reserving the product is waiting for. A past or
     * missing release date leaves Klepsidro's own answer alone.
     */
    public function filterCountdownEnd(mixed $timestamp, mixed $product): mixed
    {
        if (! $product instanceof \WC_Product) {
            return $timestamp;
        }

        return $this->nextReleaseTimestamp($product) ?? $timestamp;
    }

    /**
     * Release wording on the Klepsidro timer, so it does not read "Sale ends in".
     *
     * Only when the timer actually shows this product's release time, in case
     * another filter chose a different end.
     *
     * @param array<string, mixed> $args
     * @return array<string, mixed>
     */
    public function filterCountdownArgs(array $args, string $template): array
    {
        if ('single-product/countdown' !== $template || empty($args['product_id'])) {
            return $args;
        }

        $product = wc_get_product((int) $args['product_id']);

        if (! $product instanceof \WC_Product) {
            return $args;
        }

        $release = $this->nextReleaseTimestamp($product);

        if (null === $release || ($args['end_ts'] ?? null) !== $release) {
            return $args;
        }

        $args['lead'] = __('Releases in', 'rezervo');
        /* translators: %s: time left until the release, e.g. "2 hrs 5 min". */
        $args['announce'] = __('Releases in %s', 'rezervo');
        $args['label'] = __('Release countdown', 'rezervo');
        $args['expired_message'] = __('The release date has arrived.', 'rezervo');

        return $args;
    }

    /**
     * Start of the earliest release day still ahead (store timezone), or null.
     *
     * A variable product counts down to the first of its pre-order variations
     * to come out; a variation without its own date inherits the parent's.
     */
    private function nextReleaseTimestamp(\WC_Product $product): ?int
    {
        if (! $this->meta->hasPreorderInTree($product)) {
            return null;
        }

        $candidates = [$product];

        if ($product->is_type('variable')) {
            foreach ($product->get_children() as $childId) {
                $candidates[] = wc_get_product($childId);
            }
        }

        $now  = time();
        $next = null;

        foreach ($candidates as $candidate) {
            if (! $this->applies($candidate)) {
                continue;
            }

            $date = \DateTimeImmutable::createFromFormat('!Y-m-d', $this->meta->releaseDate($candidate), wp_timezone());

            if (! $date instanceof \DateTimeImmutable) {
                continue;
            }

            $timestamp = $date->getTimestamp();

            if ($timestamp > $now && (null === $next || $timestamp < $next)) {
                $next = $timestamp;
            }
        }

        return $next;
    }

    private function applies(mixed $product): bool
    {
        return $product instanceof \WC_Product && $this->meta->isPreorder($product);
    }

    /**
     * @param bool $purchasable Current purchasability.
     */
    public function filterPurchasable(bool $purchasable, \WC_Product $product): bool
    {
        if ($purchasable || ! $this->applies($product)) {
            return $purchasable;
        }

        // A pre-order must still have a price to be purchasable.
        return '' !== (string) $product->get_price();
    }

    /**
     * @param bool $inStock Current stock status.
     */
    public function filterInStock(bool $inStock, \WC_Product $product): bool
    {
        if ($inStock || ! $this->applies($product)) {
            return $inStock;
        }

        return true;
    }

    /**
     * @param bool $allowed Current backorder permission.
     */
    public function filterBackordersAllowed(bool $allowed, int $productId): bool
    {
        if ($allowed) {
            return $allowed;
        }

        $product = wc_get_product($productId);
        if (! $this->applies($product)) {
            return $allowed;
        }

        return true;
    }

    /**
     * @param string $text Current button label.
     */
    public function filterButtonText(string $text, \WC_Product $product): string
    {
        if (! $this->applies($product)) {
            return $text;
        }

        return $this->settings->defaultButtonText();
    }

    /**
     * Enqueue the storefront stub assets only on a single pre-order product.
     */
    public function enqueueAssets(): void
    {
        if (! function_exists('is_product') || ! is_product()) {
            return;
        }

        $product = wc_get_product(get_the_ID());
        if (! $product instanceof \WC_Product || ! $this->meta->hasPreorderInTree($product)) {
            return;
        }

        wp_enqueue_style(
            'preorder-storefront',
            PREORDER_URL . 'assets/css/storefront.css',
            [],
            \Preorder\VERSION
        );

        wp_enqueue_script(
            'preorder-storefront',
            PREORDER_URL . 'assets/js/storefront.js',
            ['jquery'],
            \Preorder\VERSION,
            true
        );

        wp_localize_script(
            'preorder-storefront',
            'preorderStorefront',
            [
                'buttonText' => $this->settings->defaultButtonText(),
            ],
        );
    }

    /**
     * Render the reservation stub on the single product page.
     *
     * Presentation only: a paper claim-ticket that tells the shopper the item
     * is inbound and they are holding a place in line. The cart behaviour is
     * handled by the filters above and is unaffected by this output.
     */
    /**
     * "Expected release: 5 June 2026", or an empty string when there is no date.
     *
     * Shared with the variation payload so the storefront cannot end up with
     * two different wordings or two different date formats for one fact.
     */
    private function releaseSentence(string $release): string
    {
        if ($release === '') {
            return '';
        }

        $timestamp = strtotime($release . ' 12:00:00');

        if ($timestamp === false) {
            return '';
        }

        return sprintf(
            /* translators: %s: formatted release date */
            __('Expected release: %s', 'rezervo'),
            wp_date((string) get_option('date_format'), $timestamp),
        );
    }

    public function renderStub(): void
    {
        global $product;

        if (! $product instanceof \WC_Product || ! $this->meta->hasPreorderInTree($product)) {
            return;
        }

        $visible = $this->applies($product);
        $title   = __('Reserved as a pre-order', 'rezervo');
        $note    = __('Not in stock yet, your order holds a place in line and ships when it arrives.', 'rezervo');
        $release = $visible ? $this->meta->releaseDate($product) : '';

        printf(
            '<div class="preorder-stub%1$s" role="note"%2$s>',
            $visible ? '' : ' preorder-stub--hidden',
            $product->is_type('variable') ? ' data-preorder-variable="1"' : '',
        );
        echo '<span class="preorder-stub__punch" aria-hidden="true"></span>';
        echo '<span class="preorder-stub__label">';
        echo '<span class="preorder-stub__title">';
        echo '<span class="preorder-stub__eyelet" aria-hidden="true"></span>';
        echo esc_html($title);
        echo '</span>';
        echo '<span class="preorder-stub__note">' . esc_html($note) . '</span>';
        // Always print the element, even empty. On a variable product the date
        // belongs to the variation, so the script fills this in on
        // show_variation, and it cannot fill in an element that is not there.
        printf(
            '<span class="preorder-stub__release">%s</span>',
            esc_html($this->releaseSentence($release)),
        );
        echo '</span>';
        echo '</div>';
    }

    /**
     * Expose per-variation pre-order state to the variations form JSON.
     *
     * @param array<string, mixed> $data
     * @return array<string, mixed>
     */
    public function addVariationData(array $data, \WC_Product_Variable $product, \WC_Product_Variation $variation): array
    {
        unset($product);

        $isPreorder = $this->applies($variation);

        $data['preorder_is_preorder']      = $isPreorder;
        $data['preorder_add_to_cart_text'] = $isPreorder ? $this->settings->defaultButtonText() : '';
        $release = $isPreorder ? $this->meta->releaseDate($variation) : '';

        $data['preorder_release_date'] = $release;
        // The raw date above was published and never read by anything, so a
        // variation's release date never reached the shopper: the stub prints
        // the PARENT product's date, and a variable product rarely has one.
        // This carries the finished sentence, formatted and translated once on
        // the server, so the script has nothing to format.
        $data['preorder_release_text'] = $this->releaseSentence($release);

        return $data;
    }

    /**
     * Flag the cart item when a pre-order product is added.
     *
     * @param array<string, mixed> $cartItemData Existing cart item data.
     * @return array<string, mixed>
     */
    public function addCartItemData(array $cartItemData, int $productId, int $variationId): array
    {
        $targetId = $variationId > 0 ? $variationId : $productId;
        $product  = wc_get_product($targetId);

        if (! $this->applies($product)) {
            return $cartItemData;
        }

        $cartItemData[self::CART_FLAG] = true;

        return $cartItemData;
    }

    /**
     * Surface the pre-order flag in the cart and checkout line item.
     *
     * @param array<int, array{key: string, value: string, display?: string}> $itemData Existing display rows.
     * @param array<string, mixed>                                             $cartItem The cart item.
     * @return array<int, array{key: string, value: string, display?: string}>
     */
    public function displayCartItemData(array $itemData, array $cartItem): array
    {
        if (empty($cartItem[self::CART_FLAG])) {
            return $itemData;
        }

        $itemData[] = [
            'key'   => __('Pre-order', 'rezervo'),
            'value' => __('Yes', 'rezervo'),
        ];

        return $itemData;
    }

    /**
     * Copy the pre-order flag onto the order line item for fulfilment.
     *
     * @param array<string, mixed> $values The cart item values.
     */
    public function addOrderItemMeta(
        \WC_Order_Item_Product $item,
        string $cartItemKey,
        array $values,
        \WC_Order $order
    ): void {
        if (empty($values[self::CART_FLAG])) {
            return;
        }

        $item->add_meta_data(__('Pre-order', 'rezervo'), __('Yes', 'rezervo'), true);
        $item->add_meta_data(self::ORDER_LINE_KEY, 'yes', true);
    }
}
