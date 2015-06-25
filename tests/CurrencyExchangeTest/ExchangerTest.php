<?php

namespace CurrencyExchangeTest;

class ExchangerTest extends \PHPUnit_Framework_TestCase
{
	public function testExchangeMethodReturnsRightValue()
	{
		$exchanger = $this->getMockBuilder('\CurrencyExchange\Exchanger')
						  ->setMethods(array('getExchangeRate'))
						  ->getMock();

		$exchanger->expects($this->once())
			->method('getExchangeRate')
			->willReturn(1.35);

		return $this->assertEquals(2.7, $exchanger->exchange(2, 'EUR', 'GBP'));
	}
}
