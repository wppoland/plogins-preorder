<?php
/**
 * PRO upsell content, generated from the plogins.com registry by
 * scripts/gen-pro-upsell.mjs. The admin upsell renders this; curate the
 * feature list to fit this plugin's settings screen (do not invent features).
 *
 * @package plogins-preorder-pro
 */

defined('ABSPATH') || exit;

return [
    'name'       => 'Preorder Pro',
    'url'        => 'https://plogins.com/plogins-preorder-pro/pricing/',
    'sellable'   => true,
    'price_from' => 29,
    'currency'   => 'EUR',
    'price_pln'  => 129,
    'lead'       => [
        'en' => 'The incentive discount, checkout deposit, per-variation pre-orders and release emails ship in version 0.4.0.',
        'pl' => 'Rabat, zaliczka, przedsprzedaż per wariant i e-maile o premierze są wdrożone w wydaniu 0.4.0.',
    ],
    'features'   => [
        [
            'en' => ['title' => 'Incentive discount', 'desc' => 'A configurable percentage discount applied to every pre-order line in the cart (shipped).'],
            'pl' => ['title' => 'Rabat motywacyjny', 'desc' => 'Konfigurowalny rabat procentowy stosowany do każdej linii przedsprzedaży w koszyku (wdrożone).'],
        ],
        [
            'en' => ['title' => 'Checkout deposit', 'desc' => 'A configurable deposit percentage charged on pre-order lines; the balance is due on release (shipped).'],
            'pl' => ['title' => 'Zaliczka przy kasie', 'desc' => 'Konfigurowalny procent zaliczki pobierany od linii przedsprzedaży; reszta do zapłaty przy premierze (wdrożone).'],
        ],
        [
            'en' => ['title' => 'Per-variation pre-orders', 'desc' => 'Mark individual variations as pre-orders with optional per-variation release dates (PerVariationPreorder, shipped).'],
            'pl' => ['title' => 'Przedsprzedaż per wariant', 'desc' => 'Oznacz poszczególne warianty jako przedsprzedaż z opcjonalną datą premiery (PerVariationPreorder, wdrożone).'],
        ],
        [
            'en' => ['title' => 'Release emails', 'desc' => 'Automatic customer notifications on the product release date (ReleaseEmails, shipped).'],
            'pl' => ['title' => 'E-maile o premierze', 'desc' => 'Automatyczne powiadomienia klientów w dniu premiery produktu (ReleaseEmails, wdrożone).'],
        ],
        [
            'en' => ['title' => 'Discount and deposit settings', 'desc' => 'Enable each feature and set percentages under WooCommerce → Pre-order Discount and Pre-order Deposit.'],
            'pl' => ['title' => 'Ustawienia rabatu i zaliczki', 'desc' => 'Włącz funkcje i ustaw procenty w WooCommerce → Rabat przedsprzedaży oraz Zaliczka przedsprzedaży.'],
        ],
    ],
];
