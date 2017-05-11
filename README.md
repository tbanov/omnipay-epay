# Omnipay: Epay

**ePay.bg driver for the Omnipay PHP payment processing library**

[Omnipay](https://github.com/thephpleague/omnipay) is a framework agnostic, multi-gateway payment
processing library for PHP 5.3+. This package implements Epay, EasyPay, Bpay and more Bugarian online payment providers support for Omnipay.

## Installation

Omnipay is installed via [Composer](http://getcomposer.org/). To install, simply run:

```
composer require gentor/omnipay-epay
```

### The following gateways are provided by this package:
* [Epay (Epay Chekcout)](https://www.epay.bg/v3main/front?lang=en)
* [EasyPay Payment Services](https://www.easypay.bg/site/en/)

For general usage instructions, please see the main [Omnipay](https://github.com/thephpleague/omnipay)
repository.

# Basic Usage

### Purchase

```php
use Omnipay\Omnipay;

$provider = Epay; # Or Easypay
$gateway = Omnipay::create($provider);
$gateway->setMin('Epay Merchant Id');
$gateway->setSignature('Epay Signature');

$response = $gateway->purchase(
    [
        'amount' => '10.00', // BGN
        'transactionId' => 'Unique ID in your system',
        'returnUrl' => 'your.site.com/return',
        'cancelUrl' => 'your.site.com/cancel',
    ]
)->send();

if ($response->isSuccessful()) {
    // only EasyPay get IDN
    echo($response->getRedirectData());
} elseif ($response->isRedirect()) {
    // redirect to epay payment gateway
    $response->redirect();
} else {
    // payment failed: display message to customer
    echo $response->getMessage();
}
```

### Webhook
* Listener for payment status

```php
//Use only epay gateway
$gateway = Omnipay::create('Epay');
$gateway->setMin('Epay Merchant Id');
$gateway->setSignature('Epay Signature');

$response = $gateway->acceptNotification()->send();

if ($response->isSuccessful()) {
    $status = $response->getTransactionStatus();
    // Response is required for epay gateway to stop sending data
    echo $response->getData()['notify_text'];
} else {
    // Response is required for epay gateway to stop sending data
    echo $response->getData()['notify_text'];
}
```

### [ePay.bg Documentation](https://www.epay.bg/v3main/front?p=mrcs_tech)
