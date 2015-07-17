CurrencyExchange
=================
[![Build Status](https://travis-ci.org/teknoman/currency-exchange.svg?branch=master)](https://travis-ci.org/teknoman/currency-exchange)

A library to retrieve currency exchanges using several web services. It's framework agnostic, so you can install it on Zend, Symfony, Silex, Yii and so on.

## Installation
Add this library in your composer.json:

```js
"require": {
	"teknoman/currency-exchange": "3.0.*"
}
```

Now tell composer to download the library by running the command:

```bash
$ php composer.phar update teknoman/currency-exchange
```

Composer will install the library to your project `vendor/teknoman` directory.
## Usage
```php
<?php

$exchanger = new \CurrencyExchange\Exchanger();

// This method will print the current exchange rate from Euros to U.S. Dollars using default web service (YahooFinance)
$result = $exchanger->getExchangeRate('EUR', 'USD');

// This method will exchange 14 Euros in the correspondant U.S. Dollars, it uses the default exchange service (YahooFinance)
$result = $exchanger->exchange(14, 'EUR', 'USD');
```

Alternatively, you can set your preferred exchange service:
```php
<?php

$exchanger = new \CurrencyExchange\Exchanger('GrandTrunk');

// This method will print the current exchange rate from Euros to U.S. Dollars using GrandTrunk web service
$result = $exchanger->getExchangeRate('EUR', 'USD');

// This method will exchange 14 Euros in the correspondant U.S. Dollars using GrandTrunk web service
$result = $exchanger->exchange(14, 'EUR', 'USD');
```

If you need to use a proxy, you can set it by invoking `setProxy()` method on `$exchanger` instance:
```php
$exchanger->setProxy('example.host.com:8080'); // In the format 'host:port'
```
## Release 3.0
In release 3.0.* the db part has been removed and will be included in a future new package 
that will require this package as a dependency. Moreover, in this release the 
Zend's packages has been removed and the http requests are performed with Guzzle