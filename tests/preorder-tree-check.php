<?php

/**
 * Asking "does anything in this product tree pre-order" must not cost a product
 * object per variation.
 *
 * hasPreorderInTree() loaded every variation with wc_get_product() and asked
 * each one, and the single product page asks the question twice: once to decide
 * whether to enqueue the storefront assets, once to render the stub. A product
 * with fifty variations and no pre-order anywhere built a hundred product
 * objects, each of which reads its own meta, to be told no.
 *
 * A variation with no flag of its own inherits the parent's, and the parent is
 * checked first, so the remaining question is one meta value per variation.
 * This harness asserts the answer is unchanged, that nothing is hydrated to
 * reach it, and that an add-on filtering `preorder/is_preorder` is still shown
 * every variation.
 *
 * Run: php tests/preorder-tree-check.php
 */

declare(strict_types=1);

define('ABSPATH', __DIR__);

/** @var array<int, WC_Product> $preorder_test_products Stubs by post id. */
$preorder_test_products = [];

/** @var array<int, array<string, string>> $preorder_test_meta Post meta by post id. */
$preorder_test_meta = [];

/** @var int $preorder_test_hydrations wc_get_product() calls. */
$preorder_test_hydrations = 0;

/** @var int $preorder_test_primes update_meta_cache() calls. */
$preorder_test_primes = 0;

/** @var callable|null $preorder_test_filter Stands in for an add-on. */
$preorder_test_filter = null;

// phpcs:disable
function get_post_meta(int $postId, string $key, bool $single = false)
{
    global $preorder_test_meta;
    return $preorder_test_meta[$postId][$key] ?? '';
}

function update_meta_cache(string $type, array $ids)
{
    global $preorder_test_primes;
    ++$preorder_test_primes;
    return [];
}

function has_filter(string $hook, $callback = false): bool
{
    global $preorder_test_filter;
    return 'preorder/is_preorder' === $hook && null !== $preorder_test_filter;
}

function apply_filters(string $hook, $value, ...$args)
{
    global $preorder_test_filter;

    if ('preorder/is_preorder' === $hook && null !== $preorder_test_filter) {
        return ($preorder_test_filter)($value, ...$args);
    }

    return $value;
}

function wc_get_product($id = null)
{
    global $preorder_test_hydrations, $preorder_test_products;
    ++$preorder_test_hydrations;

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

$meta = new \Preorder\ProductMeta();

/**
 * Register a variable parent and its variations, as both post meta (what the
 * cheap path reads) and product stubs (what the filtered path loads).
 *
 * @param array<int, array<string, string>> $variations Meta by variation id.
 * @param array<string, string>             $parentMeta
 */
function preorder_test_tree_of(int $parentId, array $variations, array $parentMeta = []): WC_Product
{
    global $preorder_test_products, $preorder_test_meta;

    $parent = new WC_Product($parentId, 'variable', array_keys($variations), $parentMeta);

    $preorder_test_products[$parentId] = $parent;
    $preorder_test_meta[$parentId]     = $parentMeta;

    foreach ($variations as $variationId => $variationMeta) {
        $preorder_test_products[$variationId] = new WC_Product(
            $variationId,
            'variation',
            [],
            $variationMeta,
            $parentId,
        );
        $preorder_test_meta[$variationId] = $variationMeta;
    }

    return $parent;
}

/**
 * @return array{0: bool, 1: int, 2: int} answer, hydrations, meta-cache primes
 */
function preorder_test_tree(\Preorder\ProductMeta $meta, WC_Product $product): array
{
    global $preorder_test_hydrations, $preorder_test_primes;
    $preorder_test_hydrations = 0;
    $preorder_test_primes     = 0;

    $answer = $meta->hasPreorderInTree($product);

    return [$answer, $preorder_test_hydrations, $preorder_test_primes];
}

$failures = [];

// One variation carries the flag: the tree pre-orders, and nothing is loaded.
$flagged = preorder_test_tree_of(10, [
    11 => [],
    12 => ['_preorder_enabled' => 'yes'],
    13 => ['_preorder_enabled' => ''],
]);
[$answer, $hydrations, $primes] = preorder_test_tree($meta, $flagged);
if (true !== $answer) {
    $failures[] = 'a flagged variation was not found';
}
if (0 !== $hydrations) {
    $failures[] = sprintf('a flagged variation cost %d product load(s), expected 0', $hydrations);
}
if (1 !== $primes) {
    $failures[] = sprintf('the variation meta was primed %d time(s), expected 1', $primes);
}

// No variation carries it: the answer is no, and still nothing is loaded. This
// is the case that used to be the most expensive, because it never short-cut.
$none = preorder_test_tree_of(20, [
    21 => [],
    22 => ['_preorder_enabled' => ''],
]);
[$answer, $hydrations, $primes] = preorder_test_tree($meta, $none);
if (false !== $answer) {
    $failures[] = 'a tree with no pre-order answered yes';
}
if (0 !== $hydrations) {
    $failures[] = sprintf('a tree with no pre-order cost %d product load(s), expected 0', $hydrations);
}
if (1 !== $primes) {
    $failures[] = sprintf('a tree with no pre-order primed meta %d time(s), expected 1', $primes);
}

// The parent's own flag still wins without touching the variations at all.
$parentFlagged = preorder_test_tree_of(30, [31 => [], 32 => []], ['_preorder_enabled' => 'yes']);
[$answer, $hydrations, $primes] = preorder_test_tree($meta, $parentFlagged);
if (true !== $answer || 0 !== $hydrations || 0 !== $primes) {
    $failures[] = 'a flagged parent no longer answers on its own';
}

// A variable product with no variations yet.
$empty = preorder_test_tree_of(40, []);
[$answer, $hydrations, $primes] = preorder_test_tree($meta, $empty);
if (false !== $answer || 0 !== $primes) {
    $failures[] = 'a variable product with no variations was not answered for free';
}

// An add-on filtering the answer must still be asked about every variation,
// which means the variations have to be loaded for it.
$preorder_test_filter = static function (bool $enabled, $product): bool {
    return $enabled || 22 === $product->get_id();
};
[$answer, $hydrations, $primes] = preorder_test_tree($meta, $none);
if (true !== $answer) {
    $failures[] = 'an add-on flagging a variation was ignored';
}
if (0 === $hydrations) {
    $failures[] = 'an add-on was never shown a variation';
}
$preorder_test_filter = null;

if ([] !== $failures) {
    fwrite(STDERR, "preorder-tree-check: FAIL\n");
    foreach ($failures as $failure) {
        fwrite(STDERR, '  ' . $failure . "\n");
    }
    exit(1);
}

echo "preorder-tree-check: OK (5 cases, no product object loaded to read a flag)\n";
