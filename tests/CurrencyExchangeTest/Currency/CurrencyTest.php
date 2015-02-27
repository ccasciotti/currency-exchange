<?php

namespace CurrencyExchangeTest\Currency;

use CurrencyExchange\Currency\Currency;

class CurrencyTest extends \PHPUnit_Framework_TestCase
{
	public function testSetCodeSetUppercasedCode()
	{
		$currency = new Currency('eur');

        $this->assertRegExp('/[A-Z]/', $currency->getCode());
	}
}
