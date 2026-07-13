=== Plogins Preorder - Pre-Orders for WooCommerce ===
Contributors: motylanogha
Tags: woocommerce, preorder, pre-order, backorder, out of stock
Requires at least: 6.5
Tested up to: 7.0
Requires PHP: 8.1
Stable tag: 1.0.2
Requires Plugins: woocommerce
License: GPLv2 or later
License URI: https://www.gnu.org/licenses/gpl-2.0.html

Lass Kunden kommende oder nicht vorrätige WooCommerce-Produkte über einen individuellen Button zum Hinzufügen zum Warenkorb vorbestellen.

== Description ==

Mit Plogins Preorder verkaufst du WooCommerce-Produkte, bevor sie auf Lager sind. Setze ein Häkchen
beim Produkt, und es bleibt kaufbar, selbst wenn sein Lagerstatus „nicht vorrätig“ ist,
sodass ein Kunde eine kommende Veröffentlichung oder einen Nachschub reservieren kann, statt
auf einer toten „Nicht vorrätig“-Seite zu landen.

Im Shop erhalten vorbestellbare Produkte einen individuellen Button-Text (zum Beispiel
„Jetzt vorbestellen“), und jede Vorbestellungszeile wird im Warenkorb markiert und in die
Bestellung übernommen, sodass du Vorbestellungen beim Packen und Versenden auseinanderhalten kannst.

= Documentation and links =

* <strong>Dokumentation</strong> - https://plogins.com/de/plogins-preorder/docs/
* <strong>Plugin-Seite</strong> - https://plogins.com/de/plogins-preorder/
* <strong>Quellcode</strong> - https://github.com/wppoland/plogins-preorder
* <strong>Fehlerberichte und Funktionswünsche</strong> - https://github.com/wppoland/plogins-preorder/issues


= Features =

* Ein Kontrollkästchen <strong>Vorbestellung</strong> bei jedem Produkt, unter <strong>Produktdaten → Allgemein</strong>.
* Ein individueller Button-Text für vorbestellbare Produkte, shopweit festgelegt.
* Vorbestellbare Produkte bleiben kaufbar, solange ihr Lagerstatus „nicht vorrätig“ ist.
* Warenkorb und Kasse zeigen bei jeder Vorbestellungszeile eine Zeile „Vorbestellung: Ja“.
* Diese Markierung wird in die Bestellposition übernommen, sodass sie auf dem Bestellbildschirm und den Lieferscheinen erscheint.
* Ein Bildschirm <strong>WooCommerce → Vorbestellungen</strong> mit einem shopweiten Ein/Aus-Schalter und dem Standard-Button-Text.
* Wird der Ein/Aus-Schalter ausgeschaltet, verhalten sich markierte Produkte wieder wie normale Produkte, ohne dass du jedes einzeln bearbeiten musst.
* Formulare sind nonce-geprüft und auf Nutzer beschränkt, die WooCommerce verwalten können; die Ausgabe wird escaped und die Eingabe bereinigt.
* Wird mit einer Übersetzungsvorlage (plogins-preorder.pot) und einer polnischen Übersetzung geliefert; beim Entfernen des Plugins wird seine Einstellung gelöscht.
* Funktioniert mit WooCommerce HPOS und den Warenkorb- und Kassen-Blocks.

== Installation ==

1. Lade das Plugin nach `/wp-content/plugins/preorder` hoch oder installiere es über Plugins → Installieren.
2. Aktiviere es. WooCommerce muss aktiv sein.
3. Bearbeite ein Produkt, öffne <strong>Produktdaten → Allgemein</strong> und setze bei <strong>Vorbestellung</strong> ein Häkchen.
4. Passe die shopweiten Standardwerte unter <strong>WooCommerce → Vorbestellungen</strong> an.

== Frequently Asked Questions ==

= Does it require WooCommerce? =

Ja. WooCommerce muss installiert und aktiv sein.

= What happens when a product is marked as a pre-order? =

Es wird kaufbar, auch wenn es nicht vorrätig ist, sein Button-Text zum Hinzufügen zum Warenkorb
ändert sich, und die Warenkorb- und Bestellzeilen werden als Vorbestellungen markiert.

= Can I pause pre-orders without editing every product? =

Ja. Schalte den globalen Schalter unter <strong>WooCommerce → Vorbestellungen</strong> aus, dann verhalten sich
markierte Produkte wie normale Produkte, bis du ihn wieder einschaltest.

= Can guests buy pre-order products? =

Ja, wenn das Produkt kaufbar ist und dein Shop den Gast-Checkout erlaubt.

= How are pre-orders shown in the cart? =

Warenkorb- und Bestellpositionen werden markiert, sodass du und der Kunde sehen könnt, welche Zeilen Vorbestellungen sind.


= Does this plugin work on WordPress Multisite? =

Ja. Dieses Plugin ist mit WordPress Multisite kompatibel. Aktiviere es netzwerkweit oder auf einzelnen Websites; jede Website behält ihre eigenen Einstellungen und Daten.

== Screenshots ==

1. Das Vorbestellungsfeld im WooCommerce-Produkteditor.
2. Der Einstellungsbildschirm WooCommerce → Vorbestellungen.

== External Services ==

Plogins Preorder stellt keine Verbindung zu externen Diensten her. Es sendet keine ausgehenden
HTTP-Anfragen, lädt keine entfernten Skripte, Schriften oder Analysen und sendet keine Daten von
deiner Website fort. Alles läuft auf deiner eigenen WordPress-Installation: der shopweite Button-Text
und der Ein/Aus-Schalter liegen in der Option `preorder_settings`, die Markierung pro Produkt
wird als Produkt-Meta `_preorder_enabled` gespeichert, und jede Vorbestellungs-Bestellzeile
trägt einen Positions-Metawert „Vorbestellung: Ja“. Das Plugin sendet keine
E-Mail.

== Translations ==

Plogins Preorder enthält deutsche, polnische und spanische Übersetzungen für die Plugin-Oberfläche. Die Textdomain ist `plogins-preorder`, sodass Sprachpakete von WordPress.org diese mitgelieferten Übersetzungen ebenfalls überschreiben oder erweitern können.

== Changelog ==

= 1.0.2 =
* Deutsche, polnische und spanische Übersetzungen für die Plugin-Oberfläche mitgeliefert.

= 1.0.1 =
* Erste stabile Version.

= 0.1.3 =
* In „Plogins Preorder for WooCommerce“ umbenannt, für einen unverwechselbareren Plugin-Namen.

= 0.1.2 =
* Feld für das erwartete Veröffentlichungsdatum bei Produkten (`ProductMeta::META_RELEASE_DATE`, Filter `preorder/release_date`).
* Veröffentlichungsdatum im Vorbestellungs-Stub im Shop und im Variations-JSON angezeigt.
* Verstecktes Bestellpositions-Meta `_preorder_line` für Add-on-Abfragen.

= 0.1.1 =
* Filter `preorder/is_preorder` und Variationsvererbung in `ProductMeta` hinzugefügt.
* Vorbestellungsstatus pro Variation im Variationsformular für Add-ons bereitgestellt.

= 0.1.0 =
* Erstveröffentlichung: Vorbestellungs-Markierung pro Produkt, individueller Button-Text, Kaufbarkeit bei nicht vorrätiger Ware sowie Warenkorb- und Bestellmarkierung, mit einem Einstellungsbildschirm.
