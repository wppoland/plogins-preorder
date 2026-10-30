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

/**
 * Remove this plugin's options from the current site.
 */
function preorder_uninstall_site(): void
{
    delete_option('preorder_settings');
    delete_option('preorder_db_version');
}

// Options are per site, so a network uninstall has to visit every site.
if (is_multisite()) {
    foreach (get_sites(['fields' => 'ids', 'number' => 0]) as $preorder_site_id) {
        switch_to_blog((int) $preorder_site_id);
        preorder_uninstall_site();
        restore_current_blog();
    }
    unset($preorder_site_id);
} else {
    preorder_uninstall_site();
}

// The PRO banner's dismissal is stored per user, so it belongs to the
// plugin rather than to the site content. User meta is global, not
// per-site, which is why this uses delete_metadata's \$delete_all rather
// than a loop over the users of one blog.
delete_metadata('user', 0, 'preorder_pro_banner_dismissed', '', true);
