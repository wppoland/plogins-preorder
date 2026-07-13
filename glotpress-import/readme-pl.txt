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

Pozwól klientom zamawiać w przedsprzedaży nadchodzące lub niedostępne produkty WooCommerce za pomocą niestandardowego przycisku dodawania do koszyka.

== Description ==

Plogins Preorder pozwala sprzedawać produkty WooCommerce, zanim trafią do magazynu. Zaznacz pole
przy produkcie, a pozostanie on dostępny do kupienia nawet wtedy, gdy jego stan magazynowy to brak
na stanie — dzięki temu klient może zarezerwować nadchodzącą premierę lub uzupełnienie zapasów, zamiast
trafiać na martwą stronę „brak na stanie”.

W sklepie produkty w przedsprzedaży otrzymują niestandardową etykietę przycisku dodawania do koszyka (np.
„Zamów w przedsprzedaży”), a każda pozycja przedsprzedaży jest oznaczana w koszyku i kopiowana
do zamówienia, dzięki czemu możesz odróżnić przedsprzedaże podczas pakowania i wysyłki.

= Documentation and links =

* <strong>Dokumentacja</strong> - https://plogins.com/pl/plogins-preorder/docs/
* <strong>Strona wtyczki</strong> - https://plogins.com/pl/plogins-preorder/
* <strong>Kod źródłowy</strong> - https://github.com/wppoland/plogins-preorder
* <strong>Raporty o błędach i prośby o nowe funkcje</strong> - https://github.com/wppoland/plogins-preorder/issues


= Features =

* Pole wyboru <strong>Przedsprzedaż</strong> przy każdym produkcie, w sekcji <strong>Dane produktu → Ogólne</strong>.
* Niestandardowa etykieta przycisku dodawania do koszyka dla produktów w przedsprzedaży, ustawiana dla całego sklepu.
* Produkty w przedsprzedaży pozostają dostępne do kupienia, gdy ich stan magazynowy to „brak na stanie”.
* Koszyk i kasa pokazują wiersz „Przedsprzedaż: Tak” przy każdej pozycji w przedsprzedaży.
* Ta flaga jest kopiowana do pozycji zamówienia, więc widać ją na ekranie zamówienia i na listach pakowania.
* Ekran <strong>WooCommerce → Przedsprzedaż</strong> z przełącznikiem włącz/wyłącz dla całego sklepu i domyślnym tekstem przycisku.
* Wyłączenie przełącznika sprawia, że oznaczone produkty znów zachowują się jak zwykłe produkty, bez edytowania każdego z osobna.
* Formularze są zabezpieczone nonce i ograniczone do użytkowników mogących zarządzać WooCommerce; dane wyjściowe są escapowane, a wejściowe oczyszczane.
* Dostarczany z szablonem tłumaczenia (plogins-preorder.pot) i polskim tłumaczeniem; usunięcie wtyczki kasuje jego ustawienie.
* Współpracuje z WooCommerce HPOS oraz blokami koszyka i kasy.

== Installation ==

1. Prześlij wtyczkę do `/wp-content/plugins/preorder` lub zainstaluj przez Wtyczki → Dodaj nową.
2. Aktywuj ją. WooCommerce musi być aktywne.
3. Edytuj produkt, otwórz <strong>Dane produktu → Ogólne</strong> i zaznacz <strong>Przedsprzedaż</strong>.
4. Dostosuj domyślne ustawienia dla całego sklepu w sekcji <strong>WooCommerce → Przedsprzedaż</strong>.

== Frequently Asked Questions ==

= Does it require WooCommerce? =

Tak. WooCommerce musi być zainstalowane i aktywne.

= What happens when a product is marked as a pre-order? =

Staje się dostępny do kupienia nawet wtedy, gdy nie ma go na stanie, zmienia się etykieta jego przycisku
dodawania do koszyka, a pozycje koszyka i zamówienia zostają oznaczone jako przedsprzedaże.

= Can I pause pre-orders without editing every product? =

Tak. Wyłącz globalny przełącznik w sekcji <strong>WooCommerce → Przedsprzedaż</strong>, a oznaczone
produkty będą zachowywać się jak zwykłe produkty, dopóki nie włączysz go ponownie.

= Can guests buy pre-order products? =

Tak, jeśli produkt można kupić, a Twój sklep zezwala na realizację zamówienia jako gość.

= How are pre-orders shown in the cart? =

Pozycje koszyka i zamówienia są oznaczane, dzięki czemu Ty i klient widzicie, które wiersze są przedsprzedażami.


= Does this plugin work on WordPress Multisite? =

Tak. Ta wtyczka jest zgodna z WordPress Multisite. Aktywuj ją w całej sieci lub na poszczególnych witrynach; każda witryna zachowuje własne ustawienia i dane.

== Screenshots ==

1. Pole przedsprzedaży w edytorze produktów WooCommerce.
2. Ekran ustawień WooCommerce → Przedsprzedaż.

== External Services ==

Plogins Preorder nie łączy się z żadnymi usługami zewnętrznymi. Nie wykonuje żadnych wychodzących żądań
HTTP, nie ładuje zdalnych skryptów, czcionek ani narzędzi analitycznych i nie wysyła żadnych danych poza
Twoją witrynę. Wszystko działa na Twojej własnej instalacji WordPress: tekst przycisku dla całego sklepu
oraz przełącznik włącz/wyłącz są zapisane w opcji `preorder_settings`, flaga dla poszczególnych produktów
jest przechowywana jako metadana produktu `_preorder_enabled`, a każda pozycja zamówienia w przedsprzedaży
zawiera metawartość pozycji „Przedsprzedaż: Tak”. Wtyczka nie wysyła żadnych
e-maili.

== Translations ==

Plogins Preorder zawiera polskie, niemieckie i hiszpańskie tłumaczenia interfejsu wtyczki. Domena tekstowa to `plogins-preorder`, więc pakiety językowe z WordPress.org mogą też nadpisywać lub rozszerzać dołączone tłumaczenia.

== Changelog ==

= 1.0.2 =
* Dodano dołączone polskie, niemieckie i hiszpańskie tłumaczenia interfejsu wtyczki.

= 1.0.1 =
* Pierwsza stabilna wersja.

= 0.1.3 =
* Zmieniono nazwę na Plogins Preorder dla WooCommerce, aby uzyskać bardziej charakterystyczną nazwę wtyczki.

= 0.1.2 =
* Pole oczekiwanej daty premiery przy produktach (`ProductMeta::META_RELEASE_DATE`, filtr `preorder/release_date`).
* Data premiery pokazywana w module przedsprzedaży w sklepie oraz w danych JSON wariantu.
* Ukryta metadana pozycji zamówienia `_preorder_line` na potrzeby zapytań dodatków.

= 0.1.1 =
* Dodano filtr `preorder/is_preorder` oraz dziedziczenie wariantów w `ProductMeta`.
* Udostępniono stan przedsprzedaży poszczególnych wariantów w formularzu wariantów na potrzeby dodatków.

= 0.1.0 =
* Pierwsze wydanie: flaga przedsprzedaży dla poszczególnych produktów, niestandardowy tekst przycisku, możliwość zakupu przy braku na stanie oraz oznaczanie koszyka i zamówień, wraz z ekranem ustawień.
