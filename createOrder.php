<?php

declare(strict_types=1);

use RetailCrm\Api\Interfaces\ClientExceptionInterface;
use RetailCrm\Api\Enum\CountryCodeIso3166;
use RetailCrm\Api\Factory\SimpleClientFactory;
use RetailCrm\Api\Interfaces\ApiExceptionInterface;
use RetailCrm\Api\Model\Entity\CustomersCorporate\Company;
use RetailCrm\Api\Model\Entity\Orders\Items\Offer;
use RetailCrm\Api\Model\Entity\Orders\Items\OrderProduct;
use RetailCrm\Api\Model\Entity\Orders\Items\PriceType;
use RetailCrm\Api\Model\Entity\Orders\Order;
use RetailCrm\Api\Model\Request\Orders\OrdersCreateRequest;

require __DIR__.'/vendor/autoload.php';

$client = SimpleClientFactory::createClient('https://superposuda.retailcrm.ru/', 'QlnRWTTWw9lv3kjxy1A8byjUmBQedYqb');

$request         = new OrdersCreateRequest();
$order           = new Order();
$offer           = new Offer();
$item            = new OrderProduct();
$company         = new Company();

$offer->article     = 'AZ105R';
$company->brand     = 'Azalita';

$item->productName   = 'Маникюрный набор AZ105R Azalita';
$item->offer         = $offer;

$order->items          = [$item];
$order->orderType      = 'fizik';
$order->number         = '7111987';
$order->orderMethod    = 'test';
$order->countryIso     = CountryCodeIso3166::KAZAKHSTAN;
$order->firstName      = 'Чуакбаев';
$order->lastName       = 'Бауыржан';
$order->patronymic     = 'Сембаевич';
$order->status         = 'trouble';
$order->managerComment = 'https://github.com/Keipa-code/RetailCRM-Test';
$order->customFields   = [
    "prim" => false,
];

$request->order = $order;
$request->site  = 'test';

try {
    $response = $client->orders->create($request);
} catch (ApiExceptionInterface | ClientExceptionInterface $exception) {
    echo $exception; // Every ApiExceptionInterface instance should implement __toString() method.
    exit(-1);
}

printf(
    'Created order id = %d with the following data: %s',
    $response->id,
    print_r($response->order, true)
);