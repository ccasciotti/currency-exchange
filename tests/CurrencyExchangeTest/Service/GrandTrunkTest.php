<?php

namespace CurrencyExchangeTest\Service;

class GrandTrunkTest extends \PHPUnit_Framework_TestCase
{
    public function testGetExchangeRateReturnCorrectRate()
    {
        $stubResponse = $this->getMockBuilder('\GuzzleHttp\Message\Response')
                             ->setConstructorArgs(array(200))
                             ->setMethods(array('getBody'))
                             ->getMock();

        $stubResponse->expects($this->any())
                     ->method('getBody')
                     ->willReturn(1.23);

        $stubService = $this->getMockBuilder('\CurrencyExchange\Service\GrandTrunk')
                            ->setMethods(array('getResponseContent'))
                            ->getMock();

        $stubService->expects($this->once())
                    ->method('getResponseContent')
                    ->willReturn($stubResponse);

        $this->assertEquals(1.23, $stubService->getExchangeRate());
    }

    public function testGetExchangeRateThrowsParseExceptionWhenRateIsNotFound()
    {
        $this->setExpectedException('\CurrencyExchange\Exception\ParseException');

        $stubResponse = $this->getMockBuilder('\GuzzleHttp\Message\Response')
                             ->setConstructorArgs(array(200))
                             ->setMethods(array('getBody'))
                             ->getMock();

        $stubResponse->expects($this->any())
                     ->method('getBody')
                     ->willReturn(null);

        $stubService = $this->getMockBuilder('\CurrencyExchange\Service\GrandTrunk')
                            ->setMethods(array('getResponseContent'))
                            ->getMock();

        $stubService->expects($this->once())
                    ->method('getResponseContent')
                    ->willReturn($stubResponse);

        $stubService->getExchangeRate();
    }
}