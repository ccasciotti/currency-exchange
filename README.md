currency-exchange
=================

A Zend Framework 2 module to make currency exchanges.

A simple usage:

$method = new CurrencyExchange\Methods\YahooFinance();
$method->setFromCurrencyCode('EUR');
$method->setToCurrencyCode('USD');
$exchanger = new CurrencyExchange\Exchanger();
$exchanger->setMethod($method);
$result = $exchanger->exchange(14); // This method will exchange 14 Euros in the correspondant U.S. Dollars

Alternatively, you can use a more simple code:

$exchanger = new CurrencyExchange\Exchanger();

// This method will exchange 14 Euros in the correspondant U.S. Dollars like the first, but it uses the default exchange method (GrandTrunk)
$result = $exchanger->exchange(14, 'EUR', 'USD');