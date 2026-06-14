# Preorder - Pre-Orders for WooCommerce

Let customers pre-order upcoming or out-of-stock WooCommerce products with a
release date and a custom button label.

Mark any product as a pre-order from the product editor. It then stays
purchasable while out of stock, gets a custom add-to-cart label, shows an
optional release-date notice, and is flagged as a pre-order in the cart and on
the order.

## Features (free)

- Per-product pre-order flag (Product data → General).
- Optional release date, shown as the estimated availability date.
- Custom add-to-cart button label — global default plus per-product override.
- Pre-order products stay purchasable while out of stock.
- Cart, checkout and order lines flagged as pre-orders (cart item + order item meta).
- A **WooCommerce → Pre-orders** settings screen (global on/off, default button text, show release date).
- Escaped output, sanitised input, nonce-protected forms, `manage_woocommerce` admin gate.
- Translation ready (POT included), clean uninstall, HPOS + cart/checkout blocks compatible.

## Architecture

- `preorder.php` — header, HPOS declaration, boots `Plugin::instance()->boot()` on `init:0`.
- `Plugin::boot()` resolves services from a tiny DI `Container`, runs `Migrator`, registers hooks, then fires `do_action('preorder/booted', $plugin)` for PRO companions.
- `src/Service/PreorderService.php` — storefront behaviour (purchasability, button text, release notice, cart/order flagging).
- `src/Admin/ProductDataPanel.php` — product editor fields.
- `src/Admin/Settings.php` — the WooCommerce submenu settings page.

## Development

```bash
composer install
composer cs        # PHPCS (WordPress security ruleset)
composer analyse   # PHPStan level 6
```

## PRO companion

`wppoland/preorder-pro` (private) boots via `add_action('preorder/booted', …)`
and adds premium features on top of this free plugin.

## License

GPL-2.0-or-later.
