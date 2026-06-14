<?php

declare(strict_types=1);

namespace Preorder;

defined('ABSPATH') || exit;

/**
 * Reads the per-product pre-order configuration stored as product meta.
 *
 * Meta keys:
 *  - _preorder_enabled      "yes" | "" (checkbox)
 *  - _preorder_release_date "Y-m-d" | ""
 *  - _preorder_button_text  string | "" (per-product override of the global label)
 *
 * Every accessor is defensive: a missing product, missing meta or malformed
 * value yields a sane empty default rather than an error.
 */
final class ProductMeta
{
    public const META_ENABLED      = '_preorder_enabled';
    public const META_RELEASE_DATE = '_preorder_release_date';
    public const META_BUTTON_TEXT  = '_preorder_button_text';

    public function isPreorder(\WC_Product $product): bool
    {
        return 'yes' === $product->get_meta(self::META_ENABLED);
    }

    /**
     * Release date in `Y-m-d`, or an empty string if unset/invalid.
     */
    public function releaseDate(\WC_Product $product): string
    {
        $raw = (string) $product->get_meta(self::META_RELEASE_DATE);
        $raw = trim($raw);

        if ('' === $raw) {
            return '';
        }

        $date = \DateTimeImmutable::createFromFormat('Y-m-d', $raw);
        if (false === $date || $date->format('Y-m-d') !== $raw) {
            return '';
        }

        return $raw;
    }

    /**
     * Localised, human-readable release date, or an empty string if unset.
     */
    public function releaseDateDisplay(\WC_Product $product): string
    {
        $raw = $this->releaseDate($product);
        if ('' === $raw) {
            return '';
        }

        $timestamp = strtotime($raw . ' 00:00:00 UTC');
        if (false === $timestamp) {
            return '';
        }

        return wp_date((string) get_option('date_format', 'F j, Y'), $timestamp);
    }

    /**
     * Per-product button text override, or an empty string when none is set.
     */
    public function buttonTextOverride(\WC_Product $product): string
    {
        return trim((string) $product->get_meta(self::META_BUTTON_TEXT));
    }
}
