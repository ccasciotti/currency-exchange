<?php

namespace CurrencyExchangeTest\Service;

class GrandTrunkTest extends \PHPUnit_Framework_TestCase
{
    public function testGetExchangeRateReturnCorrectRate()
    {
        $response = 1.23;

        $stubService = $this->getMockBuilder('\CurrencyExchange\Service\GrandTrunk')
                            ->setMethods(array('getResponseContent'))
                            ->getMock();

        $stubService->expects($this->once())
                    ->method('getResponseContent')
                    ->willReturn($response);

        $this->assertEquals(1.23, $stubService->getExchangeRate());
    }

    public function testGetExchangeRateThrowsParseExceptionWhenRateIsNotFound()
    {
        $this->setExpectedException('\CurrencyExchange\Exception\ParseException');

        $response = '';

        $stubService = $this->getMockBuilder('\CurrencyExchange\Service\GrandTrunk')
                            ->setMethods(array('getResponseContent'))
                            ->getMock();

        $stubService->expects($this->once())
                    ->method('getResponseContent')
                    ->willReturn($response);

        $stubService->getExchangeRate();
    }
}