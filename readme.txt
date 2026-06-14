=== Preorder - Pre-Orders for WooCommerce ===
Contributors: wppoland
Tags: woocommerce, preorder, pre-order, backorder, release date
Requires at least: 6.5
Tested up to: 7.0
Requires PHP: 8.1
Stable tag: 0.1.0
Requires Plugins: woocommerce
License: GPLv2 or later
License URI: https://www.gnu.org/licenses/gpl-2.0.html

Let customers pre-order upcoming or out-of-stock WooCommerce products with a release date and a custom button label.

== Description ==

Preorder lets you sell WooCommerce products before they are in stock. Mark any
product as a pre-order from the product editor and it stays purchasable even when
its stock status is out of stock — so shoppers can reserve upcoming releases or
restocks instead of bouncing.

On the storefront, pre-order products get a custom add-to-cart label (for example
"Pre-order now"), an optional estimated release-date notice, and a clear pre-order
flag in the cart and on the order so you always know which lines are pre-orders.

= Features =

* Mark any simple product as a pre-order from **Product data → General**.
* Optional per-product release date, shown to shoppers as the estimated availability date.
* Custom add-to-cart button label, globally or per product.
* Pre-order products stay purchasable while out of stock.
* Cart and checkout show a clear pre-order line with the release date.
* Order line items are flagged as pre-orders (order item meta) for fulfilment.
* A **WooCommerce → Pre-orders** settings screen: global on/off, default button text, show/hide release date.
* Output escaped, input sanitised, forms nonce-protected, admin gated on manage_woocommerce.
* Translation ready (POT included) and clean uninstall.
* HPOS and cart/checkout blocks compatible.

== Installation ==

1. Upload the plugin to `/wp-content/plugins/preorder`, or install via Plugins → Add New.
2. Activate it. WooCommerce must be active.
3. Edit a product, open **Product data → General**, tick **Pre-order**, and optionally set a release date and button text.
4. Adjust store-wide defaults under **WooCommerce → Pre-orders**.

== Frequently Asked Questions ==

= Does it require WooCommerce? =

Yes. WooCommerce must be installed and active.

= What happens when a product is marked as a pre-order? =

It becomes purchasable even when out of stock, its add-to-cart button label
changes, an optional release-date notice is shown, and the cart and order lines
are flagged as pre-orders.

= Can I pause pre-orders without editing every product? =

Yes. Turn off the global toggle under **WooCommerce → Pre-orders** and flagged
products behave like normal products until you turn it back on.

= Does it work with variable products? =

The release-date notice and button label apply at the product level. Cart and
order flagging works for both simple products and variations of a pre-order
product.

== Screenshots ==

1. The pre-order fields in the WooCommerce product editor.
2. The WooCommerce → Pre-orders settings screen.

== Changelog ==

= 0.1.0 =
* Initial release: per-product pre-order flag, release date, custom button text, out-of-stock purchasability, cart and order flagging, and a settings screen.
