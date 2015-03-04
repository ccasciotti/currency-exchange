<?php

namespace CurrencyExchangeTest;

class ExchangerTest extends \PHPUnit_Framework_TestCase
{
	public function testExchangeMethodReturnsValueGreaterThanZero()
	{
		$exchanger = $this->getMockBuilder('\CurrencyExchange\Exchanger')
						  ->setMethods(array('getExchangeRate'))
						  ->getMock();

		$exchanger->expects($this->once())
			->method('getExchangeRate')
			->willReturn(1.35);

		return $this->assertEquals(2.7, $exchanger->exchange(2, 'EUR', 'GBP'));
	}

	public function testExchangeRateThrowsInvalidArgumentExceptionPassingInvalidCurrencyCode()
	{
		$this->setExpectedException('InvalidArgumentException');

		$currencyDataHandler = $this->getMockBuilder('\CurrencyExchange\Currency\CurrencyDataHandler')
						  ->setMethods(array('isValid'))
						  ->getMock();

		$currencyDataHandler->expects($this->any())
			->method('isValid')
			->willReturn(false);

		$exchanger = new \CurrencyExchange\Exchanger();
		$exchanger->setCurrencyDataHandler($currencyDataHandler);
		$exchanger->getExchangeRate('EUP', 'GBP');
	}
}
