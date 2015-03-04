<?php

namespace CurrencyExchangeTest\Currency;

use CurrencyExchange\Currency\Currency;

class CurrencyTest extends \PHPUnit_Framework_TestCase
{
	public function testSetCodeSetCodeWithThreeUppercaseCharacters()
	{
		$currency = new Currency('eur');

        $this->assertRegExp('/[A-Z]{3}/', $currency->getCode());
	}

    public function testCurrencyWithoutThreeCharactersThrowsInvalidArgumentException()
	{
		$this->setExpectedException('InvalidArgumentException');
		new Currency('ab');
	}
}
