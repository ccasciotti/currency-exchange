CurrencyExchange
=================
[![Build Status](https://travis-ci.org/teknoman/currency-exchange.svg?branch=master)](https://travis-ci.org/teknoman/currency-exchange)

A library to retrieve currency exchanges using several web services. Is not related to a framework, so it run on Zend, Symfony, Silex, Yii and so on.

## Installation
Add this library in your composer.json:

```js
"require": {
	"teknoman/currency-exchange": "2.1.*"
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
## Release 2
In release 2.* there is a currency database (for now in the form of a JSON file, the goal is to add db adapters) that is queried each time a currency is set to check its validity, it's in `data` folder. You can skip this check by setting `true` on `setSkipCurrencyDataCheck` method:
```php
$exchanger = new \CurrencyExchange\Exchanger();
$exchanger->setSkipCurrencyDataCheck(true);
$result = $exchanger->getExchangeRate('EUR', 'USD');
```
You can update the currency database with the code below:
```php
$currencyAdapter = new \CurrencyExchange\Currency\Adapter\File();
$currencyAdapter->setDownloader(new \CurrencyExchange\Currency\Downloader());
$currencyAdapter->saveData();
```