<?php

namespace CurrencyExchangeTest;

use CurrencyExchange\Factory\UriFactory;

class UriFactoryTest extends \PHPUnit_Framework_TestCase
{
    public function testUriFactoryThrowsInvalidArgumentExceptionWhenPassingInvalidUriType()
    {
        $this->setExpectedException('InvalidArgumentException');

        UriFactory::factory('unknown-uri-type');
    }

	/**
	 * @dataProvider providerTestUriFactoryReturnsInstanceOfUriAbstract
	 */
	public function testUriFactoryReturnsInstanceOfUriAbstract($service)
	{
		$instance = UriFactory::factory($service);
		return $this->assertInstanceOf('\CurrencyExchange\Uri\UriAbstract', $instance);
	}

	public function providerTestUriFactoryReturnsInstanceOfUriAbstract()
	{
		return [
            ['get'],
			['post'],
        ];
	}
}
