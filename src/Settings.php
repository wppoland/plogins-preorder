<?php

declare(strict_types=1);

namespace Preorder;

use Preorder\Service\Texts;

defined('ABSPATH') || exit;

/**
 * Typed accessor over the `preorder_settings` option. Reads are merged over the
 * shipped defaults so a partial or missing option never yields a broken state.
 *
 * Two reads on purpose: all() returns exactly what is stored, which is what the
 * settings screen must edit, and resolved() fills the customer-facing labels the
 * merchant left empty with their translated defaults, which is what the
 * storefront must print.
 */
final class Settings
{
    public const OPTION = 'preorder_settings';

    /** @var array<string, mixed>|null */
    private ?array $cache = null;

    /**
     * The raw settings: shipped defaults under whatever is stored, with the
     * customer-facing labels left exactly as the merchant left them (empty
     * included). Never print these; use resolved().
     *
     * @return array<string, mixed>
     */
    public function all(): array
    {
        if (null !== $this->cache) {
            return $this->cache;
        }

        /** @var array<string, mixed> $defaults */
        $defaults = require PREORDER_DIR . 'config/defaults.php';

        $stored = get_option(self::OPTION, []);
        if (! is_array($stored)) {
            $stored = [];
        }

        return $this->cache = array_merge($defaults, $stored);
    }

    public function isEnabled(): bool
    {
        return (bool) ($this->all()['enabled'] ?? true);
    }

    /**
     * The settings as the storefront should show them: every customer-facing
     * label the merchant left empty filled with its translated default.
     *
     * Resolved on the way out only, never written back, so no language is ever
     * frozen into the option.
     *
     * @return array<string, mixed>
     */
    public function resolved(): array
    {
        return Texts::apply($this->all());
    }

    public function defaultButtonText(): string
    {
        return (string) ($this->resolved()['default_button_text'] ?? '');
    }

    /**
     * Forget the cached option (used after a save in the same request).
     */
    public function flush(): void
    {
        $this->cache = null;
    }
}
