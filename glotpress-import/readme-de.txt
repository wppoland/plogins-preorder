=== Plogins Preorder - Pre-Orders for WooCommerce ===
Contributors: motylanogha
Tags: woocommerce, preorder, pre-order, backorder, out of stock
Requires at least: 6.5
Tested up to: 7.0
Requires PHP: 8.1
Stable tag: 1.0.1
Erfordert Plugins: woocommerce
License: GPLv2 or later
License URI: https://www.gnu.org/licenses/gpl-2.0.html

Ermögliche Kunden, bevorstehende oder nicht mehr vorrätige WooCommerce-Produkte mit einer benutzerdefinierten Schaltfläche zum Hinzufügen zum Warenkorb vorzubestellen.

== Description ==

Mit der Vorbestellung kannst du WooCommerce-Produkte verkaufen, bevor sie auf Lager sind. Kreuze ein Kästchen an
auf dem Produkt und es bleibt käuflich, auch wenn der Lagerbestand erschöpft ist
Lagerbestand, sodass ein Kunde stattdessen eine bevorstehende Veröffentlichung oder einen Nachschub reservieren kann
Du landen auf einer toten „Ausverkauft“-Seite.

Im Store erhalten vorbestellte Produkte ein individuelles Add-to-Cart-Etikett (z. B
„Jetzt vorbestellen“), und jede Vorbestellungszeile wird im Warenkorb markiert und kopiert
die Bestellung, sodass du Vorbestellungen beim Verpacken und Versenden unterscheiden können.

= Documentation and links =

* <strong>Dokumentation</strong> - https://plogins.com/de/plogins-preorder/docs/
* <strong>Plugin-Seite</strong> - https://plogins.com/de/plogins-preorder/
* <strong>Quellcode</strong> – https://github.com/wppoland/plogins-preorder
* <strong>Fehlerberichte und Funktionsanfragen</strong> – https://github.com/wppoland/plogins-preorder/issues


= Features =

* Ein Kontrollkästchen <strong>Vorbestellung</strong> für jedes Produkt unter <strong>Produktdaten → Allgemein</strong>.
* Ein benutzerdefiniertes Add-to-Cart-Label für vorbestellte Produkte, das im gesamten Geschäft festgelegt wird.
* Vorbestellte Produkte bleiben käuflich, solange ihr Lagerstatus „Ausverkauft“ ist.
* Im Warenkorb und an der Kasse wird in jeder Vorbestellungszeile die Zeile „Vorbestellung: Ja“ angezeigt.
* Diese Markierung wird in die Bestellposition kopiert, sodass sie auf dem Bestellbildschirm und auf den Lieferscheinen angezeigt wird.
* Ein Bildschirm <strong>WooCommerce → Vorbestellungen</strong> mit einem geschäftsweiten Ein-/Ausschalter und dem Standard-Schaltflächentext.
* Durch das Anhalten des Ein-/Ausschalters verhalten sich gekennzeichnete Produkte wieder wie normale Produkte, ohne dass jedes einzelne bearbeitet werden muss.
* Formulare werden nicht überprüft und sind auf Benutzer beschränkt, die WooCommerce verwalten können. Die Ausgabe wird maskiert und die Eingabe bereinigt.
* Wird mit einer Übersetzungsvorlage (plogins-preorder.pot) und einer polnischen Übersetzung geliefert; Durch das Entfernen des Plugins werden seine Einstellungen gelöscht.
* Funktioniert mit WooCommerce HPOS und den Warenkorb- und Checkout-Blöcken.

== Installation ==

1. Lade das Plugin nach „/wp-content/plugins/preorder“ hoch oder installiere es über Plugins → Neu hinzufügen.
2. Aktiviere es. WooCommerce muss aktiv sein.
3. Bearbeite ein Produkt, öffne <strong>Produktdaten → Allgemein</strong> und kreuze <strong>Vorbestellung<strong> an. 4. Passe die geschäftsweiten Standardeinstellungen unter </strong>WooCommerce → Vorbestellungen</strong> an.

== Frequently Asked Questions ==

= Does it require WooCommerce? =

Ja. WooCommerce muss installiert und aktiv sein.

= What happens when a product is marked as a pre-order? =

Dank der Schaltfläche „In den Warenkorb“ ist es auch dann käuflich, wenn es nicht vorrätig ist
Änderungen, und der Warenkorb und die Bestellzeilen werden als Vorbestellungen gekennzeichnet.

= Can I pause pre-orders without editing every product? =

Ja. Deaktiviere den globalen Schalter unter <strong>WooCommerce → Vorbestellungen</strong> und markiere ihn
Produkte verhalten sich wie normale Produkte, bis Sie sie wieder einschalten.

= Can guests buy pre-order products? =

Ja, wenn das Produkt käuflich ist und dein Geschäft die Bezahlung durch Gäste zulässt.

= How are pre-orders shown in the cart? =

Warenkorb- und Bestellpositionen werden gekennzeichnet, sodass du und der Kunde sehen können, bei welchen Zeilen es sich um Vorbestellungen handelt.


= Does this plugin work on WordPress Multisite? =

Ja. Dieses Plugin ist mit WordPress Multisite kompatibel. Aktiviere es im Netzwerk oder auf einzelnen Websites. Jede Site behält ihre eigenen Einstellungen und Daten.

== Screenshots ==

1. Das Vorbestellungsfeld im WooCommerce-Produkteditor.
2. Der WooCommerce → Einstellungsbildschirm für Vorbestellungen.

== External Services ==

Vorbestellung stellt keine Verbindung zu externen Diensten her. Es erfolgt kein ausgehendes HTTP
Anfragen, lädt keine Remote-Skripte, Schriftarten oder Analysen und sendet keine Daten
deine Website. Alles läuft über deine eigene WordPress-Installation: den Store-weiten Button
Text und Ein-/Ausschalter live in der Option „preorder_settings“ pro Produkt
Das Flag wird als Produkt-Meta „_preorder_enabled“ und bei jeder Vorbestellung gespeichert
Die Zeile enthält den Metawert „Vorbestellung: Ja“. Es wird keine E-Mail gesendet
Plugin.

== Changelog ==

= 1.0.1 =
* Erste stabile Version.

= 0.1.3 =
* Umbenannt in „Plogins Preorder for WooCommerce“, um einen eindeutigeren Plugin-Namen zu erhalten.

= 0.1.2 =
* Feld „Erwartetes Veröffentlichungsdatum“ für Produkte (Filter „ProductMeta::META_RELEASE_DATE“, „Vorbestellung/Veröffentlichungsdatum“).
* Das Veröffentlichungsdatum wird im Storefront-Vorbestellungs-Stub und in der JSON-Variante angezeigt.
* Verstecktes „_preorder_line“-Bestellelement-Meta für Add-on-Abfragen.

= 0.1.1 =
* Füge den Filter „preorder/is_preorder“ und die Variationsvererbung in „ProductMeta“ hinzu.
* Gib den Vorbestellungsstatus pro Variation im Variationsformular für Add-ons an.

= 0.1.0 =
* Erstveröffentlichung: Vorbestellungskennzeichnung pro Produkt, benutzerdefinierter Schaltflächentext, Kaufmöglichkeit für nicht vorrätige Waren sowie Warenkorb- und Bestellkennzeichnung mit einem Einstellungsbildschirm.
