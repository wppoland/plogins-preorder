<?php
/**
 * Constants needed by PHPStan to analyse the plugin without bootstrapping WordPress.
 *
 * @package Preorder
 */

declare(strict_types=1);

namespace {
    if (! defined('ABSPATH')) {
        define('ABSPATH', '/tmp/wordpress/');
    }
    if (! defined('PREORDER_DIR')) {
        define('PREORDER_DIR', '/tmp/preorder/');
    }
    if (! defined('PREORDER_URL')) {
        define('PREORDER_URL', 'https://example.test/wp-content/plugins/preorder/');
    }
    if (! defined('WP_UNINSTALL_PLUGIN')) {
        define('WP_UNINSTALL_PLUGIN', true);
    }
}

namespace Preorder {
    if (! defined('Preorder\\VERSION')) {
        define('Preorder\\VERSION', '0.1.0');
    }
    if (! defined('Preorder\\PLUGIN_FILE')) {
        define('Preorder\\PLUGIN_FILE', '/tmp/preorder/preorder.php');
    }
}
