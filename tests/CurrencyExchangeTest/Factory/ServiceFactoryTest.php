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

	public function testServiceFactoryThrowsRuntimeExceptionWhenPassingUnknownMethodAsString()
	{
		$this->setExpectedException('RuntimeException');
		ServiceFactory::factory('UnknownService');
	}

    public function testServiceFactoryThrowsRuntimeExceptionWhenPassingUnknownMethodAsNotObject()
	{
		$this->setExpectedException('RuntimeException');

        $service = true;
		ServiceFactory::factory($service);
	}

    public function testServiceFactoryThrowsRuntimeExceptionWhenPassingUnknownMethodAsObject()
	{
		$this->setExpectedException('RuntimeException');
		ServiceFactory::factory(new \stdClass());
	}

	public function testServiceFactoryInstantiatesYahooFinanceServiceAsDefault()
	{
		$instance = ServiceFactory::factory();
		return $this->assertInstanceOf('\CurrencyExchange\Service\YahooFinance', $instance);
	}

	public function providerTestServiceFactoryReturnsInstanceOfServiceAbstract()
	{
		return array(
			array('GrandTrunk'),
			array('WebServiceX'),
			array('YahooFinance'),
		);
	}
}
