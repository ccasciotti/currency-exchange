<?php

declare(strict_types=1);

namespace CurrencyExchangeTest\Exchanger;

use CurrencyExchange\Exchanger\Exchanger;
use CurrencyExchange\Service\AbstractService;
use CurrencyExchange\Uri\AbstractUri;

class ExchangerTest extends \PHPUnit\Framework\TestCase
{
	public function testGetExchangeRateMethodReturnsRightValue(): void
    {
        $expectedResult = 1.35;

        $stubUri = $this
            ->getMockBuilder(AbstractUri::class)
            ->disableOriginalConstructor()
            ->getMock()
        ;

        $stubService = $this
            ->getMockBuilder(AbstractService::class)
            ->disableOriginalConstructor()
            ->onlyMethods(['getExchangeRate', 'getUri'])
            ->getMockForAbstractClass()
        ;

        $stubService
            ->expects($this->once())
            ->method('getExchangeRate')
            ->willReturn($expectedResult)
        ;

        $stubService
            ->expects($this->once())
            ->method('getUri')
            ->willReturn($stubUri)
        ;

        /** @noinspection PhpUnitInvalidMockingEntityInspection */
        $stubExchanger = $this
            ->getMockBuilder(Exchanger::class)
            ->disableOriginalConstructor()
			->onlyMethods(['getService'])
			->getMock()
        ;

        $stubExchanger
			->method('getService')
			->willReturn($stubService);

		$this->assertEquals($expectedResult, $stubExchanger->getExchangeRate('EUR', 'USD'));
	}
}
