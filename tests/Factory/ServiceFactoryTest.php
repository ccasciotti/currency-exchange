<?php

namespace CurrencyExchangeTest\Factory;

use CurrencyExchange\Factory\ServiceFactory;
use CurrencyExchange\Service\GrandTrunk;
use CurrencyExchange\Service\ServiceInterface;
use RuntimeException;

class ServiceFactoryTest extends \PHPUnit\Framework\TestCase
{
	/**
	 * @dataProvider providerTestServiceFactoryReturnsInstanceOfServiceAbstract
	 */
	public function testServiceFactoryReturnsInstanceOfServiceInterface($service): void
    {
		$instance = ServiceFactory::create($service);
		$this->assertInstanceOf(ServiceInterface::class, $instance);
	}

	public function testServiceFactoryThrowsRuntimeExceptionWhenPassingUnknownMethodAsString(): void
    {
		$this->expectException(RuntimeException::class);

		ServiceFactory::create('UnknownService');
	}

	public function testServiceFactoryInstantiatesDefaultService(): void
    {
		$instance = ServiceFactory::create();
		$this->assertInstanceOf(ServiceFactory::$defaultExchangeService, $instance);
	}

	public function providerTestServiceFactoryReturnsInstanceOfServiceAbstract(): array
    {
		return [
            [GrandTrunk::class],
        ];
	}
}
