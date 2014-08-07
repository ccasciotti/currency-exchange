CurrencyExchange
=================

A Zend Framework 2 module to make currency exchanges using several web services.

A simple usage:
```php
<?php

$exchanger = new \CurrencyExchange\Exchanger();

// This method will print the current exchange rate from Euros to U.S. Dollars
$result = $exchanger->getExchangeRate('EUR', 'USD');

// This method will exchange 14 Euros in the correspondant U.S. Dollars, it uses the default exchange method (GrandTrunk)
$result = $exchanger->exchange(14, 'EUR', 'USD');
```

Alternatively, you can set your preferred exchange method:
```php
<?php

$exchanger = new \CurrencyExchange\Exchanger('CurrencyExchange\Methods\YahooFinance');
$result = $exchanger->exchange(14, 'EUR', 'USD'); // This method will exchange 14 Euros in the correspondant U.S. Dollars using web service of Yahoo Finance
```

If you are behind a proxy, you can set it by invoking *setProxy()* method on $exchanger instance:
```php
$exchanger->setProxy('example.host.com:8080'); // In the format 'host:port'
```
