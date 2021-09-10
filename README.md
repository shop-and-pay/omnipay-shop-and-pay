# Omnipay: Shop & Pay

**Shop & Pay driver for the Omnipay PHP payment processing library**

Shop & Pay is a framework agnostic, multi-gateway payment processing library for PHP.
This package implements Shop & Pay support for Omnipay.

## Installation

Shop & Pay is installed via [Composer](http://getcomposer.org/). To install, simply require `league/omnipay` and `shop-and-pay/omnipay-shop-and-pay` with Composer:

```
composer require league/omnipay shop-and-pay/omnipay-shop-and-pay
```


## Basic Usage

The following gateways are provided by this package:

* Shop & Pay

For general usage instructions, please see the main [Omnipay](https://github.com/thephpleague/omnipay)
repository.

### Basic purchase and refund example

```php
require __DIR__ . '/vendor/autoload.php';

use Omnipay\Omnipay;

$gateway = Omnipay::create('ShopAndPay');
$gateway->setApiKey('API_KEY'); // You find the API key in your Shop & Pay merchant backend
$gateway->setInstance('INSTANCE'); // That's your Shop & Pay instance name (INSTANCE.shop-and-pay.com)

// Let's create a Shop & Pay gateway
$response = $gateway->purchase([
    'amount' => '100', // CHF 100.00
    'currency' => 'CHF',
    'skipResultPage' => true,
    'successRedirectUrl' => 'https://www.merchant-website.com/success',
    'failedRedirectUrl' => 'https://www.merchant-website.com/failed',
])->send();

// A Shop & Pay gateway is always a redirect
if ($response->isRedirect()) {
    // Redirect URL to Shop & Pay gateway
    var_dump($response->getRedirectUrl());
    $response->redirect();
}

// That will be the Shop & Pay gateway ID
var_dump($response->getTransactionReference());

// Check if Shop & Pay gateway has been paid
$response = $gateway->completePurchase([
    'transactionReference' => $response->getTransactionReference(),
])->send();

// If Shop & Pay gateway has been paid, we will get a transaction reference (Shop & Pay transaction ID)
if ($response->getTransactionReference()) {
    // Optional: Fetch the corresponding transaction data => $response->getData()
    $response = $gateway->fetchTransaction([
        'transactionReference' => $response->getTransactionReference(),
    ])->send();

    // Let's refund CHF 50.00 (PSP has to support refunds)
    $response = $gateway->refund([
        'transactionReference' => $response->getTransactionReference(), // That's the Shop & Pay transaction ID as well
        'amount' => 50, // CHF 50.00
    ])->send();

    if ($response->isSuccessful()) {
        echo 'Refund was successful';
    }
}
```

## Support

If you are having general issues with Omnipay, we suggest posting on
[Stack Overflow](http://stackoverflow.com/). Be sure to add the
[omnipay tag](http://stackoverflow.com/questions/tagged/omnipay) so it can be easily found.

If you want to keep up to date with release anouncements, discuss ideas for the project,
or ask more detailed questions, there is also a [mailing list](https://groups.google.com/forum/#!forum/omnipay) which
you can subscribe to.

If you believe you have found a bug, fork the library and submit a pull request.
