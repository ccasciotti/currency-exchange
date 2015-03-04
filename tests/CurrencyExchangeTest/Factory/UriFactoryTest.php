<?php

namespace CurrencyExchangeTest;

use CurrencyExchange\Factory\UriFactory;

class UriFactoryTest extends \PHPUnit_Framework_TestCase
{
	/**
	 * @dataProvider providerTestUriFactoryReturnsInstanceOfUriAbstract
	 */
	public function testServiceFactoryReturnsInstanceOfServiceAbstract($service)
	{
		$instance = UriFactory::factory($service);
		return $this->assertInstanceOf('\CurrencyExchange\Uri\UriAbstract', $instance);
	}

	public function testServiceFactoryThrowsInvalidArgumentException()
	{
		$this->setExpectedException('InvalidArgumentException');
		UriFactory::factory('other-method');
	}

	public function providerTestUriFactoryReturnsInstanceOfUriAbstract()
	{
		return array(
			array('get'),
			array('post'),
		);
	}
}
