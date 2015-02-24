<?php

namespace CurrencyExchangeTest;

use CurrencyExchange\Factory\ServiceFactory;

class ServiceFactoryTest extends \PHPUnit_Framework_TestCase
{
	/**
	 * @dataProvider providerTestServiceFactoryReturnsInstanceOfServiceAbstract
	 */
	public function testServiceFactoryReturnsInstanceOfServiceAbstract($service)
	{
		$instance = ServiceFactory::factory($service);
		return $this->assertInstanceOf('\CurrencyExchange\Service\ServiceAbstract', $instance);
	}

	public function testServiceFactoryThrowsRuntimeException()
	{
		$this->setExpectedException('RuntimeException');
		$instance = ServiceFactory::factory('UnknownService');
	}

	public function testServiceFactoryInstantiatesYahooFinanceServiceAsDefault()
	{
		$instance = ServiceFactory::factory();
		return $this->assertInstanceOf('\CurrencyExchange\Service\YahooFinance', $instance);
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
