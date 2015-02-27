<?php

namespace CurrencyExchangeTest\Service;

class WebServiceXTest extends \PHPUnit_Framework_TestCase
{
    public function testGetExchangeRateReturnCorrectRate()
    {
        $response = '<?xml version="1.0" encoding="utf-8"?>'
                . '<double xmlns="http://www.webserviceX.NET/">1.1229</double>';

        $stubService = $this->getMockBuilder('\CurrencyExchange\Service\WebServiceX')
                            ->setMethods(array('getResponseContent'))
                            ->getMock();

        $stubService->expects($this->once())
                    ->method('getResponseContent')
                    ->willReturn($response);

        $this->assertGreaterThan(0, $stubService->getExchangeRate());
    }

    public function testGetExchangeRateThrowsParseExceptionWhenRateIsNotFound()
    {
        $this->setExpectedException('\CurrencyExchange\Exception\ParseException');

        $response = '<?xml version="1.0" encoding="utf-8"?>'
                . '<unknown_node>whatever</unknown_node>';

        $stubService = $this->getMockBuilder('\CurrencyExchange\Service\WebServiceX')
                            ->setMethods(array('getResponseContent'))
                            ->getMock();

        $stubService->expects($this->once())
                    ->method('getResponseContent')
                    ->willReturn($response);

        $stubService->getExchangeRate();
    }
}