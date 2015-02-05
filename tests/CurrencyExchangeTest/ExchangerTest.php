<?php

namespace CurrencyExchangeTest;

class ExchangerTest extends \PHPUnit_Framework_TestCase
{
	/**
	 * @dataProvider providerTestServiceFactoryReturnsInstanceOfServiceAbstract
	 */
	public function testServiceFactoryReturnsInstanceOfServiceAbstract($service)
	{
		$instance = \CurrencyExchange\Factory\ServiceFactory::factory($service);
		return $this->assertInstanceOf('\CurrencyExchange\Service\ServiceAbstract', $instance);
	}

	public function providerTestServiceFactoryReturnsInstanceOfServiceAbstract()
	{
		return array(
			array('GoogleExchangeRate'),
			array('GrandTrunk'),
			array('WebServiceX'),
			array('YahooFinance'),
		);
	}
}
