<?php

declare(strict_types=1);

namespace Preorder\Admin;

defined('ABSPATH') || exit;

use Preorder\Contract\HasHooks;
use Preorder\ProductMeta;

/**
 * Adds the "Pre-order" controls to the WooCommerce Product data box (General tab):
 * an enable checkbox, an optional release date, and a per-product button-text
 * override. Values are sanitised on save; the nonce WooCommerce already verifies
 * for the product editor (`woocommerce_meta_nonce`) is re-checked here.
 */
final class ProductDataPanel implements HasHooks
{
    public function registerHooks(): void
    {
        add_action('woocommerce_product_options_general_product_data', [$this, 'renderFields']);
        add_action('woocommerce_admin_process_product_object', [$this, 'saveFields']);
    }

    public function renderFields(): void
    {
        echo '<div class="options_group preorder-product-fields">';

        woocommerce_wp_checkbox([
            'id'          => ProductMeta::META_ENABLED,
            'label'       => __('Pre-order', 'preorder'),
            'description' => __('Sell this product as a pre-order. It stays purchasable even when out of stock.', 'preorder'),
        ]);

        woocommerce_wp_text_input([
            'id'                => ProductMeta::META_RELEASE_DATE,
            'label'             => __('Release date', 'preorder'),
            'type'              => 'date',
            'desc_tip'          => true,
            'description'       => __('Optional. Shown to shoppers as the estimated availability date.', 'preorder'),
            'custom_attributes' => [
                'autocomplete' => 'off',
            ],
        ]);

        woocommerce_wp_text_input([
            'id'          => ProductMeta::META_BUTTON_TEXT,
            'label'       => __('Button text', 'preorder'),
            'desc_tip'    => true,
            'description' => __('Optional. Overrides the global pre-order button label for this product.', 'preorder'),
            'placeholder' => __('Pre-order now', 'preorder'),
        ]);

        echo '</div>';
    }

    public function saveFields(\WC_Product $product): void
    {
        // WooCommerce verifies woocommerce_meta_nonce before this hook fires; re-check defensively.
        $nonce = isset($_POST['woocommerce_meta_nonce'])
            ? sanitize_text_field(wp_unslash((string) $_POST['woocommerce_meta_nonce']))
            : '';

        if ('' === $nonce || ! wp_verify_nonce($nonce, 'woocommerce_save_data')) {
            return;
        }

        $enabled = isset($_POST[ProductMeta::META_ENABLED]) ? 'yes' : '';
        $product->update_meta_data(ProductMeta::META_ENABLED, $enabled);

        $releaseRaw = isset($_POST[ProductMeta::META_RELEASE_DATE])
            ? sanitize_text_field(wp_unslash((string) $_POST[ProductMeta::META_RELEASE_DATE]))
            : '';
        $product->update_meta_data(ProductMeta::META_RELEASE_DATE, $this->sanitizeDate($releaseRaw));

        $buttonText = isset($_POST[ProductMeta::META_BUTTON_TEXT])
            ? sanitize_text_field(wp_unslash((string) $_POST[ProductMeta::META_BUTTON_TEXT]))
            : '';
        $product->update_meta_data(ProductMeta::META_BUTTON_TEXT, $buttonText);
    }

    /**
     * Accept only a valid `Y-m-d` date; anything else becomes an empty string.
     */
    private function sanitizeDate(string $value): string
    {
        $value = trim($value);
        if ('' === $value) {
            return '';
        }

        $date = \DateTimeImmutable::createFromFormat('Y-m-d', $value);
        if (false === $date || $date->format('Y-m-d') !== $value) {
            return '';
        }

        return $value;
    }
}
