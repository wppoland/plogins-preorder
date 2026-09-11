=== Plogins Preorder - Pre-Orders for WooCommerce ===
Contributors: motylanogha
Tags: woocommerce, preorder, pre-order, backorder, out of stock
Requires at least: 6.5
Tested up to: 7.1
Requires PHP: 8.1
Stable tag: 1.0.11
Requires Plugins: woocommerce
License: GPLv2 or later
License URI: https://www.gnu.org/licenses/gpl-2.0.html

Let customers pre-order upcoming or out-of-stock WooCommerce products with a custom add-to-cart button.

== Description ==

Preorder lets you sell WooCommerce products before they are in stock. Tick a box
on the product and it stays purchasable even when its stock status is out of
stock, so a customer can reserve an upcoming release or a restock instead of
landing on a dead "out of stock" page.

On the storefront, pre-order products get a custom add-to-cart label (for example
"Pre-order now"), and each pre-order line is flagged in the cart and copied onto
the order, so you can tell pre-orders apart when you pack and ship.

= Documentation and links =

* **Documentation**: [plogins.com/plogins-preorder/docs/](https://plogins.com/plogins-preorder/docs/)
* **Plugin page**: [plogins.com/plogins-preorder/](https://plogins.com/plogins-preorder/)
* **Source code**: [github.com/wppoland/plogins-preorder](https://github.com/wppoland/plogins-preorder)
* **Bug reports and feature requests**: [github.com/wppoland/plogins-preorder/issues](https://github.com/wppoland/plogins-preorder/issues)


= Features =

* A **Pre-order** checkbox on every product, under **Product data > General**.
* A custom add-to-cart label for pre-order products, set store-wide.
* Pre-order products stay purchasable while their stock status is out of stock.
* The cart and checkout show a "Pre-order: Yes" row on each pre-order line.
* That flag is copied onto the order line item, so it shows on the order screen and packing slips.
* A **WooCommerce > Pre-orders** screen with a store-wide on/off switch and the default button text.
* Pausing the on/off switch makes flagged products behave like normal products again, without editing each one.
* Forms are nonce-checked and limited to users who can manage WooCommerce; output is escaped and input sanitised.
* Ships with a translation template (plogins-preorder.pot) and a Polish translation; removing the plugin deletes its setting.
* Works with WooCommerce HPOS and the cart and checkout blocks.

== Installation ==

1. Upload the plugin to `/wp-content/plugins/preorder`, or install via Plugins > Add New.
2. Activate it. WooCommerce must be active.
3. Edit a product, open **Product data > General**, and tick **Pre-order**.
4. Adjust store-wide defaults under **WooCommerce > Pre-orders**.

== Frequently Asked Questions ==

= Does it require WooCommerce? =

Yes. WooCommerce must be installed and active.

= What happens when a product is marked as a pre-order? =

It becomes purchasable even when out of stock, its add-to-cart button label
changes, and the cart and order lines are flagged as pre-orders.

= Can I pause pre-orders without editing every product? =

Yes. Turn off the global toggle under **WooCommerce > Pre-orders** and flagged
products behave like normal products until you turn it back on.

= Can guests buy pre-order products? =

Yes, when the product is purchasable and your store allows guest checkout.

= How are pre-orders shown in the cart? =

Cart and order line items are flagged so you and the customer can see which lines are pre-orders.


= Does this plugin work on WordPress Multisite? =

Yes. This plugin is compatible with WordPress Multisite. Network activate it or activate it on individual sites; each site keeps its own settings and data.

== Screenshots ==

1. The pre-order field in the WooCommerce product editor.
2. The WooCommerce > Pre-orders settings screen.

== External Services ==

Preorder does not connect to any external services. It makes no outbound HTTP
requests, loads no remote scripts, fonts, or analytics, and sends no data off
your site. Everything runs on your own WordPress install: the store-wide button
text and on/off switch live in the `preorder_settings` option, the per-product
flag is stored as the `_preorder_enabled` product meta, and each pre-order order
line carries a "Pre-order: Yes" line item meta value. No email is sent by the
plugin.

== Translations ==

Plogins Preorder is fully translatable and ships the `plogins-preorder.pot` template. Translations are delivered by WordPress.org language packs from translate.wordpress.org, which is where Polish, German and Spanish are being contributed; the package itself carries no compiled translation files.

== Changelog ==

= 1.0.11 =
* Fixed: the PRO upgrade promo kept selling to people who had already bought the paid edition. Only the banner could be dismissed, so the sidebar promo and the locked feature cards followed a paying customer around for good. The promo now checks whether the paid edition is active and steps aside when it is.
* Fixed: arrow glyphs in the admin menu paths, and in the strings handed to translators. An arrow inside a translatable string makes the glyph every translator's problem and changes the layout in any locale that drops it.

= 1.0.10 =
* Fixed: on a variable product the expected release date never reached the shopper. Each variation stored its own date and the product page printed the parent product's, which a variable product rarely has, so the line was simply absent. Picking a variation now shows that variation's date.
* Fixed: deleting the plugin left the per-user "dismiss" flag from the PRO notice in the database. Uninstall now removes it for every user, not just the one who dismissed it.

= 1.0.9 =
* Fixed: the pre-order button always read "Pre-order now" in English, whatever language the shop ran in. The label shipped as a plain English sentence in a config file, and that value reached the storefront before the translated one was ever considered, so the Polish, German and Spanish translations of it were never used. Opening the settings screen showed the same English text in the field, and saving wrote it into the database, where it stayed English for good.
* The default label is now a translated string resolved at the moment the button is drawn, never written back to the database. It follows the site language as soon as a translation for it exists. Translations arrive as WordPress.org language packs and are not bundled in this download, so the label stays English until a pack is published. A label you typed yourself is still used exactly as typed.
* On update, a label left byte for byte as the old English default is cleared so the translated one takes over. Anything you edited, including a hand translation, is matched exactly and kept.

= 1.0.8 =
* Renamed to Plogins Preorder - Pre-Orders for WooCommerce so the name leads with the brand rather than a generic word, which is what the WordPress.org plugin review team asks for. The plugin slug is unchanged.

= 1.0.7 =
* Tested against WordPress 7.1. Verified by activating this build on a clean 7.1 install with WooCommerce 11.1, not by editing the header.

= 1.0.6 =
* Fixed the PRO promo on the settings screen quoting a price in PLN. PRO is priced and charged in EUR, so an admin on a Polish site was shown a zloty amount and then billed in euro, and the zloty figure was a fixed conversion that drifted from the real charge as the rate moved. The promo now shows the euro price that is actually taken.

= 1.0.4 =
* Translations: completed Polish, German and Spanish for the PRO upgrade panel.

= 1.0.3 =
* Fixed low-contrast admin headings under an OS dark-mode preference.

= 1.0.2 =
* Added bundled Polish, German and Spanish translations for the plugin interface.

= 1.0.1 =
* First stable release.

= 0.1.3 =
* Renamed to Plogins Preorder for WooCommerce for a more distinctive plugin name.

= 0.1.2 =
* Expected release date field on products (`ProductMeta::META_RELEASE_DATE`, `preorder/release_date` filter).
* Release date shown on the storefront pre-order stub and in variation JSON.
* Hidden `_preorder_line` order item meta for add-on queries.

= 0.1.1 =
* Add `preorder/is_preorder` filter and variation inheritance in `ProductMeta`.
* Expose per-variation pre-order state on the variations form for add-ons.

= 0.1.0 =
* Initial release: per-product pre-order flag, custom button text, out-of-stock purchasability, and cart and order flagging, with a settings screen.
