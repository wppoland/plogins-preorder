<?php
/**
 * Boot order: services listed here are resolved from the container and have
 * their registerHooks() called during Plugin::boot(). Each must implement
 * Preorder\Contract\HasHooks.
 *
 * @package Preorder
 *
 * @return array<class-string>
 */

declare(strict_types=1);

use Preorder\Admin\ProductDataPanel;
use Preorder\Admin\Settings;
use Preorder\Service\PreorderService;

defined('ABSPATH') || exit;

return is_admin()
    ? [
        PreorderService::class,
        ProductDataPanel::class,
        Settings::class,
    ]
    : [
        PreorderService::class,
    ];
