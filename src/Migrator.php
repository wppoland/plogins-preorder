<?php

declare(strict_types=1);

namespace Preorder;

defined('ABSPATH') || exit;

/**
 * Forward-only, idempotent maintenance run on every boot. There is no custom
 * table and no seeded option: pre-order state lives in product meta and the
 * settings option is written only when a merchant saves the settings screen.
 */
final class Migrator
{
    private const OPTION_VERSION = 'preorder_db_version';

    public function maybeMigrate(): void
    {
        if ((string) get_option(self::OPTION_VERSION, '') === VERSION) {
            return;
        }

        $this->clearUntranslatableTexts();

        update_option(self::OPTION_VERSION, VERSION, false);
    }

    /**
     * The English label that shipped as the packaged default up to 1.0.8.
     *
     * It was merged under the stored option, so the settings screen showed it as
     * the field value and saving wrote it into the database. Every shop that
     * ever pressed Save on that screen has English frozen there.
     *
     * @var array<string, string>
     */
    private const LEGACY_TEXTS = [
        'default_button_text' => 'Pre-order now',
    ];

    /**
     * Clear a stored label that is byte for byte the old English default, so the
     * translated one takes over. Empty means "use the translated default", which
     * is what the settings screen already promised.
     *
     * Only an exact match is cleared, so a merchant's own label, including a
     * hand translation of the English one, survives untouched.
     */
    private function clearUntranslatableTexts(): void
    {
        $stored = get_option(Settings::OPTION, null);
        if (! is_array($stored)) {
            return;
        }

        $changed = false;
        foreach (self::LEGACY_TEXTS as $key => $legacy) {
            if (isset($stored[$key]) && (string) $stored[$key] === $legacy) {
                $stored[$key] = '';
                $changed      = true;
            }
        }

        if ($changed) {
            // null keeps the option's existing autoload flag. Passing false here
            // would quietly move the settings out of the autoloaded set on every
            // shop that took this update, which is not a change a text sweep gets
            // to make.
            update_option(Settings::OPTION, $stored, null);
        }
    }
}
