CurrencyExchange
=================

A Zend Framework 2 module to make currency exchanges using several web services.

A simple usage:
```php
<?php

// Supposing $sm is an instance of Zend's Service Manager
$exchanger = $sm->get('CurrencyExchange\Exchanger');
$exchanger->setMethod('YahooFinance');

// It returns the current exchange rate from YahooFinance service
echo $exchanger->getExchangeRate('EUR', 'USD');

// It will exchange 1 eur to correspondant value in US Dollars from YahooFinance service
echo $exchanger->exchange(1, 'EUR', 'USD');
```

If you need to use a proxy, you can set it by invoking **setProxy()** method on $exchanger instance:
```php
// In the format 'host:port'
$exchanger->setProxy('example.host.com:8080');
```