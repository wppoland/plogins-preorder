<?php
/**
 * Uninstall cleanup for Preorder.
 *
 * Runs when the plugin is deleted from wp-admin. Removes the options Preorder
 * creates. Per-product pre-order meta (_preorder_enabled) is intentionally left
 * in place: it is user content that may be shared with other tools and is cheap
 * to leave.
 *
 * @package Preorder
 */

declare(strict_types=1);

defined('WP_UNINSTALL_PLUGIN') || exit;

delete_option('preorder_settings');
delete_option('preorder_db_version');

// The PRO banner's dismissal is stored per user, so it belongs to the
// plugin rather than to the site content. User meta is global, not
// per-site, which is why this uses delete_metadata's \$delete_all rather
// than a loop over the users of one blog.
delete_metadata('user', 0, 'preorder_pro_banner_dismissed', '', true);
