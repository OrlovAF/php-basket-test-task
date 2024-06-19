<?php

require "Basket.php";
require "DeliveryChargeRule.php";
require "Offer.php";
require "Product.php";


$products = [
    new Product('Red Widget', 'R01', 3295),
    new Product('Green Widget', 'G01', 2495),
    new Product('Blue Widget', 'B01', 795),
];

$deliveryChargeRules = [
    new DeliveryChargeRule(0, 5000, 495),
    new DeliveryChargeRule(5000, 9000, 295),
];

$offers = [
    new Offer('R01', 2, 0.5),
];

$basket = new Basket($products, $deliveryChargeRules, $offers);

$examples = [
    ['B01', 'G01'],
    ['R01', 'R01'],
    ['R01', 'G01'],
    ['B01', 'B01', 'R01', 'R01', 'R01'],
];

foreach ($examples as $codesList) {
    foreach ($codesList as $code) {
        $basket->add($code);
    }

    $codesListString = implode(', ', $codesList);
    $total = number_format($basket->total() / 100, 2);

    echo "{$codesListString} - \${$total}\n";

    $basket->clear();
}
