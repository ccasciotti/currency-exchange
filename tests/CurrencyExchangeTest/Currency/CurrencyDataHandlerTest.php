<?php

namespace CurrencyExchangeTest\Currency;

class CurrencyDataHandlerTest extends \PHPUnit_Framework_TestCase
{
	public function testInvalidCurrencyThrowsInvalidArgumentException()
	{
		$this->setExpectedException('InvalidArgumentException');
		$currencyDataHandler = $this->getObject();
		$currencyDataHandler->isValid('AB');
	}

	public function testDefaultAdapterIsInstanceOfAdapterFile()
	{
		$currencyDataHandler = $this->getObject();
		$this->assertInstanceOf('\CurrencyExchange\Currency\Adapter\File', $currencyDataHandler->getAdapter());
	}

	private function getObject()
	{
		return new \CurrencyExchange\Currency\CurrencyDataHandler();
	}
}
