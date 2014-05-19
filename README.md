CurrencyExchange
=================

A Zend Framework 2 module to make currency exchanges using several web services.

A simple usage:
```php
<?php

$method = new \CurrencyExchange\Methods\YahooFinance();
$method->setFromCurrencyCode('EUR');
$method->setToCurrencyCode('USD');

$exchanger = new \CurrencyExchange\Exchanger();
$exchanger->setMethod($method);
$result = $exchanger->exchange(14); // This method will exchange 14 Euros in the correspondant U.S. Dollars using web service of Yahoo Finance
```

Alternatively, you can use a more simple code:
```php
<?php

$exchanger = new \CurrencyExchange\Exchanger();

// This method will exchange 14 Euros in the correspondant U.S. Dollars like the first, but it uses the default exchange method (GrandTrunk)
$result = $exchanger->exchange(14, 'EUR', 'USD');
```

If you are behind a proxy, you can set it by invoking *setProxy()* method on $method or $exchanger instance:
```php
$method->setProxy('example.host.com:8080'); // In the format 'host:port'
// or
$exchanger->setProxy('example.host.com:8080'); // In the format 'host:port'
```
