# Omnipay: EuPago

**WARNING:** Still WIP - Usable, but with caution!

**EuPago driver for the Omnipay PHP payment processing library**

[Omnipay](https://github.com/thephpleague/omnipay) is a framework agnostic, multi-gateway payment
processing library for PHP. This package implements PayPal support for Omnipay.

## Installation

Omnipay is installed via [Composer](http://getcomposer.org/). To install, simply require `league/omnipay` and `rafaeltpires/omnipay-eupago` with Composer:

```
composer require league/omnipay rafaeltpires/omnipay-eupago
```
## Basic Usage

The following payments are provided by this package:

* Multibanco
* MBWay
* Credit Card

For general usage instructions, please see the main [Omnipay](https://github.com/thephpleague/omnipay)
repository.

## Quirks

The transaction reference obtained from the purchase() response can't be used to refund a purchase. The transaction reference from the completePurchase() response is the one that should be used.

## Support

If you believe you have found a bug, please report it using the [GitHub issue tracker](https://github.com/rafaeltpires/omnipay-eupago/issues),
or better yet, fork the library and submit a pull request.

## Usage

### Multibanco

````php
use Omnipay\Omnipay;

$gateway = Omnipay::create('EuPago\Multibanco');

$formData = [
    'key' => 'demo-008c-5a63-8245-40e',     // Required
    'amount' => '125.15',                   // Required
    'id' => 'identifier',                   // Optional
    'clientEmail' => 'jdoe@example.dev',    // Optional
    'clientPhone' => '912345678',           // Optional
    'perDup' => 0,                          // Required
    'startDate' => '2023-09-16',            // Optional
    'endDate' => '2023-10-15',              // Optional
    'maxAmount' => 0.0,                     // Optional
    'minAmount' => 0.0,                     // Optional
    'failOver' => 0,                        // Optional
    'extraFields' => [                      // Optional
        'id' => 564,
        'valor' => 'my-custom-id'
    ],
    'testMode'       => true                // Optional
];

$response = $gateway->purchase($formData)->send();

if($response->isSuccessful()) {
    echo $response->getReference() . "<br>";
    echo $response->getEntity() . "<br>";
    echo $response->getAmount() . "<br>";
    echo $response->getMaxValue() . "<br>";
    echo $response->getMinValue() . "<br>";
    echo $response->getEndDate() . "<br>";
    echo $response->getStartDate() . "<br>";
}
````

### MBWay

```php
use Omnipay\Omnipay;

$gateway = Omnipay::create('EuPago\MBWay');

$formData = [
    'key' => 'xxxx-xxxx-xxxx-xxx',          // Required
    'amount' => '125.25',                   // Required
    'clientPhone' => '912345678',           // Optional
    'id' => 'identifier',                   // Optional
    'clientEmail' => 'jdoe@example.dev',    // Optional
    'failOver' => 1,                        // Optional
    'description' => 'MyCoolStore',         // Optional
    'paymentPhone' => '912345678',          // Required
    'testMode' => true                      // Optional
];

$response = $gateway->purchase($formData)->send();

if($response->isSuccessful()) {
    echo $response->getReference() . "<br>";
    echo $response->getMessage() . "<br>";
    echo $response->getAmount() . "<br>";
}
```

### Credit Card

```php
use Omnipay\Omnipay;

$gateway = Omnipay::create('EuPago\Card');

$formData = [
    'key' => 'xxxx-xxxx-xxxx-xxx',          // Required
    'currency' => 'EUR',                    // Required 
    'amount' => '125.15',                   // Required
    'id' => 'identifier',                   // Optional
    'successUrl' => 'https://success.test', // Required
    'errorUrl' => 'https://error.test',     // Required
    'cancelUrl' => 'https://cancel.test',   // Required
    'notify' => 1,                          // Required
    'language' => 'PT',                     // Required
    'clientEmail' => 'jdoe@example.dev',    // Required
    'testMode' => true,                     // Optional
];

$response = $gateway->purchase($formData)->send();

if($response->isSuccessful()) {
    header('Location: ' . $response->getRedirectUrl());
}
```

## Props

Adapted from [Stowify/omnipay-ifthenpay](https://github.com/Stowify/omnipay-ifthenpay) 👌
