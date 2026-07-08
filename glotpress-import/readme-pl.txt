=== Plogins Preorder - Pre-Orders for WooCommerce ===
Contributors: motylanogha
Tags: woocommerce, preorder, pre-order, backorder, out of stock
Requires at least: 6.5
Tested up to: 7.0
Requires PHP: 8.1
Stable tag: 1.0.1
Wymaga wtyczek: woocommerce
License: GPLv2 or later
License URI: https://www.gnu.org/licenses/gpl-2.0.html

Pozwól klientom zamawiać w przedsprzedaży nadchodzące lub niedostępne produkty WooCommerce za pomocą niestandardowego przycisku dodawania do koszyka.

== Description ==

Preorder umożliwia sprzedaż produktów WooCommerce, zanim będą dostępne w magazynie. Zaznacz pole
na produkcie i można go kupić nawet po wyczerpaniu się zapasów
zapasów, dzięki czemu klient może zamiast tego zarezerwować nadchodzące wydanie lub uzupełnienie zapasów
lądowanie na martwej stronie „niedostępny”.

W sklepie produkty zamówione w przedsprzedaży otrzymują niestandardową etykietę dodawania do koszyka (np
„Zamów teraz w przedsprzedaży”), a każda pozycja zamówienia w przedsprzedaży jest oznaczana w koszyku i kopiowana
zamówienia, aby móc je rozróżnić podczas pakowania i wysyłki.

= Documentation and links =

* <strong>Dokumentacja</strong> - https://plogins.com/pl/plogins-preorder/docs/
* <strong>Strona wtyczki</strong> - https://plogins.com/pl/plogins-preorder/
* <strong>Kod źródłowy</strong> - https://github.com/wppoland/plogins-preorder
* <strong>Raporty o błędach i prośby o nowe funkcje</strong> - https://github.com/wppoland/plogins-preorder/issues


= Features =

* Pole wyboru <strong>Zamów w przedsprzedaży</strong> przy każdym produkcie w sekcji <strong>Dane produktu → Ogólne</strong>.
* Niestandardowa etykieta dodawania do koszyka dla produktów zamówionych w przedsprzedaży, stosowana w całym sklepie.
* Produkty zamówione w przedsprzedaży można kupić do czasu wyczerpania się ich stanu magazynowego.
* Koszyk i kasa zawierają wiersz „Zamówienie w przedsprzedaży: Tak” w każdej linii zamówienia w przedsprzedaży.
* Ta flaga jest kopiowana do pozycji zamówienia, więc jest widoczna na ekranie zamówienia i listach przewozowych.
* Ekran <strong>WooCommerce → Przedsprzedaż</strong> z włącznikiem/wyłącznikiem obejmującym cały sklep i domyślnym tekstem przycisku.
* Wstrzymanie włącznika/wyłącznika powoduje, że oznaczone produkty znów zachowują się jak normalne produkty, bez edytowania każdego z nich.
* Formularze są sprawdzane jednorazowo i ograniczone do użytkowników, którzy mogą zarządzać WooCommerce; wyjście jest usuwane, a wejście oczyszczane.
* Dostarczany z szablonem tłumaczenia (plogins-preorder.pot) i tłumaczeniem na język polski; usunięcie wtyczki powoduje usunięcie jej ustawień.
* Współpracuje z WooCommerce HPOS oraz blokami koszyka i kasy.

== Installation ==

1. Prześlij wtyczkę do `/wp-content/plugins/preorder` lub zainstaluj poprzez Wtyczki → Dodaj nową.
2. Aktywuj. WooCommerce musi być aktywny.
3. Edytuj produkt, otwórz <strong>Dane produktu → Ogólne</strong> i zaznacz <strong>Zamów w przedsprzedaży<strong>. 4. Dostosuj ustawienia domyślne dla całego sklepu w sekcji </strong>WooCommerce → Zamówienia w przedsprzedaży</strong>.

== Frequently Asked Questions ==

= Does it require WooCommerce? =

Tak. WooCommerce musi być zainstalowany i aktywny.

= What happens when a product is marked as a pre-order? =

Można go kupić nawet wtedy, gdy nie ma go w magazynie, dzięki etykiecie z przyciskiem „dodaj do koszyka”.
zmiany, a koszyk i wiersze zamówienia zostaną oznaczone jako zamówienia w przedsprzedaży.

= Can I pause pre-orders without editing every product? =

Tak. Wyłącz globalny przełącznik w sekcji <strong>WooCommerce → Przedsprzedaż</strong> i oznacz
produkty zachowują się jak normalne produkty, dopóki nie włączysz ich ponownie.

= Can guests buy pre-order products? =

Tak, jeśli produkt jest możliwy do kupienia, a Twój sklep umożliwia realizację transakcji jako gość.

= How are pre-orders shown in the cart? =

Pozycje koszyka i zamówienia są oznaczone, dzięki czemu Ty i klient możecie zobaczyć, które wiersze są zamówieniami w przedsprzedaży.


= Does this plugin work on WordPress Multisite? =

Tak. Ta wtyczka jest kompatybilna z WordPress Multisite. Aktywuj go w sieci lub aktywuj na poszczególnych stronach; każda witryna przechowuje własne ustawienia i dane.

== Screenshots ==

1. Pole zamówienia w przedsprzedaży w edytorze produktów WooCommerce.
2. Ekran WooCommerce → Ustawienia zamówień w przedsprzedaży.

== External Services ==

Preorder nie łączy się z żadnymi usługami zewnętrznymi. Nie tworzy wychodzącego protokołu HTTP
żądań, nie ładuje zdalnych skryptów, czcionek ani analiz i nie wysyła żadnych danych
Twoja witryna. Wszystko działa na Twojej własnej instalacji WordPress: przycisk obejmujący cały sklep
tekst i włącznik/wyłącznik znajdują się w opcji „preorder_settings”, dla poszczególnych produktów
flaga jest przechowywana jako meta produktu `_preorder_enabled` i każdego zamówienia w przedsprzedaży
wiersz zawiera metawartość elementu zamówienia „Zamówienie w przedsprzedaży: Tak”. Żaden e-mail nie jest wysyłany przez
wtyczka.

== Changelog ==

= 1.0.1 =
* Pierwsza stabilna wersja.

= 0.1.3 =
* Zmieniono nazwę na Plogins Preorder dla WooCommerce, aby uzyskać bardziej charakterystyczną nazwę wtyczki.

= 0.1.2 =
* Pole oczekiwanej daty wydania produktów (filtr „ProductMeta::META_RELEASE_DATE”, „preorder/release_date”).
* Data premiery podana na odcinku zamówienia w przedsprzedaży w sklepie oraz w wersji JSON.
* Ukryta meta pozycji zamówienia „_preorder_line” dla zapytań o dodatki.

= 0.1.1 =
* Dodaj filtr `preorder/is_preorder` i dziedziczenie odmian w `ProductMeta`.
* Wyświetlanie stanu zamówienia w przedsprzedaży poszczególnych wersji w formularzu wersji dodatków.

= 0.1.0 =
* Pierwsza wersja: flaga zamówienia w przedsprzedaży dla poszczególnych produktów, niestandardowy tekst przycisku, możliwość zakupu w przypadku wyczerpania zapasów oraz oznaczanie koszyka i zamówień z ekranem ustawień.
