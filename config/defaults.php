<?php
/**
 * Default settings, merged under the option key `preorder_settings`.
 *
 * @package Preorder
 *
 * @return array<string, mixed>
 */

declare(strict_types=1);

defined('ABSPATH') || exit;

return [
    'enabled' => true,

    // The customer-facing button label is empty on purpose. A value here is not
    // a gettext call, so it never reaches the .pot and no language pack can
    // reach it, and the settings screen would then save that English text into
    // the option. Empty means "use Preorder\Service\Texts", which is translated;
    // anything a merchant types still wins.
    'default_button_text' => '',
];
