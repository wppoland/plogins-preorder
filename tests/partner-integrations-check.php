<?php

/**
 * Rezervo's answers to Waitlist and Klepsidro, including variations.
 *
 * - Waitlist: a pre-order product or variation takes no "Notify me" signups;
 *   a variable parent passes through so each variation is asked on its own.
 * - Klepsidro: the countdown ends at the earliest release day still ahead,
 *   in the store timezone; a past or missing date leaves Klepsidro's answer.
 *
 * Run: php tests/partner-integrations-check.php
 */

declare(strict_types=1);

namespace Preorder\Contract {
    interface HasHooks
    {
    }
}

namespace {
    define('ABSPATH', __DIR__);
    define('PREORDER_DIR', dirname(__DIR__) . '/');

    /** @var array<int, WC_Product> $preorder_test_products */
    $preorder_test_products = [];

    // phpcs:disable
    function get_post_meta(int $postId, string $key, bool $single = false)
    {
        global $preorder_test_products;
        $product = $preorder_test_products[$postId] ?? null;
        return $product ? $product->get_meta($key) : '';
    }

    function update_meta_cache(string $type, array $ids) { return []; }
    function has_filter(string $hook, $callback = false): bool { return false; }
    function apply_filters(string $hook, $value, ...$args) { return $value; }
    function __(string $text, string $domain = ''): string { return $text; }
    function wp_timezone(): DateTimeZone { return new DateTimeZone('Europe/Warsaw'); }

    function wc_get_product($id = null)
    {
        global $preorder_test_products;
        return $preorder_test_products[(int) $id] ?? false;
    }

    class WC_Product
    {
        /**
         * @param array<int, int>       $children
         * @param array<string, string> $meta
         */
        public function __construct(
            private int $id,
            private string $type,
            private array $children = [],
            private array $meta = [],
            private int $parentId = 0,
        ) {
            $GLOBALS['preorder_test_products'][$id] = $this;
        }

        public function get_id(): int { return $this->id; }
        public function is_type($type): bool { return $this->type === $type; }
        public function meta_exists(string $key): bool { return array_key_exists($key, $this->meta); }
        public function get_meta(string $key, bool $single = true) { return $this->meta[$key] ?? ''; }
        public function get_parent_id(): int { return $this->parentId; }

        /** @return array<int, int> */
        public function get_children(): array { return $this->children; }
    }
    // phpcs:enable

    require __DIR__ . '/../src/ProductMeta.php';
    require __DIR__ . '/../src/Settings.php';
    require __DIR__ . '/../src/Service/PreorderService.php';

    $service = new \Preorder\Service\PreorderService(new \Preorder\Settings(), new \Preorder\ProductMeta());

    $failures = 0;
    $check = static function (string $label, bool $ok) use (&$failures): void {
        echo ($ok ? 'ok    ' : 'FAIL  ') . $label . "\n";
        $failures += $ok ? 0 : 1;
    };

    $tz       = new DateTimeZone('Europe/Warsaw');
    $dayStart = static fn (string $modify): int => (new DateTimeImmutable('today', $tz))->modify($modify)->getTimestamp();
    $date     = static fn (string $modify): string => (new DateTimeImmutable('today', $tz))->modify($modify)->format('Y-m-d');
    $on       = ['_preorder_enabled' => 'yes'];

    // Waitlist.
    $simplePre = new WC_Product(1, 'simple', [], $on);
    $simple    = new WC_Product(2, 'simple');
    $check('pre-order product: no waitlist', false === $service->filterWaitlistAccepts(true, $simplePre));
    $check('plain product: waitlist answer unchanged', true === $service->filterWaitlistAccepts(true, $simple));
    $check('never turns a no into a yes', false === $service->filterWaitlistAccepts(false, $simple));

    $mixed = new WC_Product(10, 'variable', [11, 12]);
    new WC_Product(11, 'variation', [], $on, 10);
    new WC_Product(12, 'variation', [], [], 10);
    $check('variable parent passes through', true === $service->filterWaitlistAccepts(true, $mixed));
    $check('pre-order variation: no waitlist', false === $service->filterWaitlistAccepts(true, wc_get_product(11)));
    $check('plain variation of the same product keeps it', true === $service->filterWaitlistAccepts(true, wc_get_product(12)));

    $inheritParent = new WC_Product(20, 'variable', [21], $on);
    new WC_Product(21, 'variation', [], [], 20);
    $check('variation inheriting the parent flag: no waitlist', false === $service->filterWaitlistAccepts(true, wc_get_product(21)));

    // Klepsidro.
    $future = new WC_Product(30, 'simple', [], $on + ['_preorder_release_date' => $date('+10 days')]);
    $check('future release: countdown to its day start, store timezone', $dayStart('+10 days') === $service->filterCountdownEnd(null, $future));
    $check('release date wins over a sale end', $dayStart('+10 days') === $service->filterCountdownEnd(time() + 60, $future));

    $past = new WC_Product(31, 'simple', [], $on + ['_preorder_release_date' => $date('-1 day')]);
    $check('past release leaves the sale end', 123 === $service->filterCountdownEnd(123, $past));
    $check('release today has started, leaves null', null === $service->filterCountdownEnd(null, new WC_Product(32, 'simple', [], $on + ['_preorder_release_date' => $date('+0 days')])));
    $check('no date leaves null', null === $service->filterCountdownEnd(null, new WC_Product(33, 'simple', [], $on)));
    $check('date on a non-pre-order is ignored', null === $service->filterCountdownEnd(null, new WC_Product(34, 'simple', [], ['_preorder_release_date' => $date('+3 days')])));

    $variable = new WC_Product(40, 'variable', [41, 42, 43, 44]);
    new WC_Product(41, 'variation', [], $on + ['_preorder_release_date' => $date('+20 days')], 40);
    new WC_Product(42, 'variation', [], $on + ['_preorder_release_date' => $date('+5 days')], 40);
    new WC_Product(43, 'variation', [], $on + ['_preorder_release_date' => $date('-2 days')], 40);
    new WC_Product(44, 'variation', [], ['_preorder_release_date' => $date('+1 day')], 40);
    $check('variable: earliest future release among pre-order variations', $dayStart('+5 days') === $service->filterCountdownEnd(null, $variable));

    $inherit = new WC_Product(50, 'variable', [51], $on + ['_preorder_release_date' => $date('+7 days')]);
    new WC_Product(51, 'variation', [], [], 50);
    $check('variable: parent date counts', $dayStart('+7 days') === $service->filterCountdownEnd(null, $inherit));

    // Wording only when the timer shows the release.
    $args = $service->filterCountdownArgs(['product_id' => 30, 'end_ts' => $dayStart('+10 days')], 'single-product/countdown');
    $check('release wording on the release countdown', 'Releases in' === ($args['lead'] ?? null) && 'Releases in %s' === ($args['announce'] ?? null));
    $args = $service->filterCountdownArgs(['product_id' => 30, 'end_ts' => 999], 'single-product/countdown');
    $check('no release wording when another end was chosen', ! isset($args['lead']));
    $args = $service->filterCountdownArgs(['product_id' => 2, 'end_ts' => 999], 'single-product/countdown');
    $check('no release wording on a plain product', ! isset($args['lead']));
    $args = $service->filterCountdownArgs(['product_id' => 30, 'end_ts' => $dayStart('+10 days')], 'other');
    $check('other templates untouched', ! isset($args['lead']));

    echo 0 === $failures ? "\nAll checks passed.\n" : "\n{$failures} check(s) failed.\n";
    exit(0 === $failures ? 0 : 1);
}
