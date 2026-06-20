<?php

declare(strict_types=1);

namespace Preorder;

defined('ABSPATH') || exit;

/**
 * Reads the per-product pre-order configuration stored as product meta.
 *
 * Meta keys:
 *  - _preorder_enabled "yes" | "" (checkbox)
 *
 * The accessor is defensive: a missing product or meta value yields a sane
 * default rather than an error.
 */
final class ProductMeta
{
    public const META_ENABLED = '_preorder_enabled';

    /**
     * Whether the product (or variation) is flagged as a pre-order.
     *
     * Variations without their own meta inherit the parent product flag.
     * Add-ons filter `preorder/is_preorder` to extend or override the result.
     */
    public function isPreorder(\WC_Product $product): bool
    {
        $enabled = $this->resolveEnabled($product);

        /**
         * Filter whether a product or variation is treated as a pre-order.
         *
         * @param bool        $enabled Resolved pre-order flag before filtering.
         * @param \WC_Product $product The product or variation being checked.
         */
        return (bool) apply_filters('preorder/is_preorder', $enabled, $product);
    }

    /**
     * Whether this product or any of its variations is flagged as a pre-order.
     *
     * Used on variable parent products to decide whether storefront assets
     * should load before a variation is selected.
     */
    public function hasPreorderInTree(\WC_Product $product): bool
    {
        if ($this->isPreorder($product)) {
            return true;
        }

        if (! $product->is_type('variable')) {
            return false;
        }

        foreach ($product->get_children() as $childId) {
            $child = wc_get_product($childId);
            if ($child instanceof \WC_Product && $this->isPreorder($child)) {
                return true;
            }
        }

        return false;
    }

    private function resolveEnabled(\WC_Product $product): bool
    {
        if ($product->is_type('variation')) {
            if ($product->meta_exists(self::META_ENABLED)) {
                return 'yes' === $product->get_meta(self::META_ENABLED);
            }

            $parent = wc_get_product($product->get_parent_id());
            if ($parent instanceof \WC_Product) {
                return $this->resolveEnabled($parent);
            }

            return false;
        }

        return 'yes' === $product->get_meta(self::META_ENABLED);
    }
}
