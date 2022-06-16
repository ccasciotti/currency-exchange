CurrencyExchange
=================
[![Build Status](https://travis-ci.org/teknoman/currency-exchange.svg?branch=master)](https://travis-ci.org/teknoman/currency-exchange)

A library to retrieve currency exchanges using several web services. It's framework agnostic, so you can install it on Symfony, Laravel, Lumen and so on.

## Installation
Add this library in your composer.json:

```shell
composer require ccasciotti/currency-exchange:~4.0
```

Now tell composer to download the library by running the command:

Composer will install the library to your project `vendor` directory.
## Usage

```php
<?php

// require composer's autoload
require 'vendor/autoload.php';

use CurrencyExchange\Exchanger\Exchanger;

$exchanger = new Exchanger();

// This method will print the current exchange rate from Euros to U.S. Dollars using default web service (YahooFinance)
$result = $exchanger->getExchangeRate('EUR', 'USD');
```
