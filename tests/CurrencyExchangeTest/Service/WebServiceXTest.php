<?php

namespace CurrencyExchangeTest\Service;

class WebServiceXTest extends \PHPUnit_Framework_TestCase
{
    public function testGetExchangeRateReturnCorrectRate()
    {
        $xmlResponse = '<?xml version="1.0" encoding="utf-8"?>'
                . '<double xmlns="http://www.webserviceX.NET/">1.23</double>';

        $stubResponse = $this->getMockBuilder('\GuzzleHttp\Message\Response')
                             ->setConstructorArgs(array(200))
                             ->setMethods(array('getBody'))
                             ->getMock();

        $stubResponse->expects($this->any())
                     ->method('getBody')
                     ->willReturn($xmlResponse);

        $stubService = $this->getMockBuilder('\CurrencyExchange\Service\WebServiceX')
                            ->setMethods(array('getResponseContent'))
                            ->getMock();

        $stubService->expects($this->once())
                    ->method('getResponseContent')
                    ->willReturn($stubResponse);

        $this->assertEquals(1.23, $stubService->getExchangeRate());
    }

    public function testGetExchangeRateThrowsParseExceptionWhenRateIsNotFoundOrIsZero()
    {
        $this->setExpectedException('\CurrencyExchange\Exception\ParseException');

        $xmlResponse = '<?xml version="1.0" encoding="utf-8"?>'
                . '<unknown_node>whatever</unknown_node>';

        $stubResponse = $this->getMockBuilder('\GuzzleHttp\Message\Response')
                             ->setConstructorArgs(array(200))
                             ->setMethods(array('getBody'))
                             ->getMock();

        $stubResponse->expects($this->any())
                     ->method('getBody')
                     ->willReturn($xmlResponse);

        $stubService = $this->getMockBuilder('\CurrencyExchange\Service\WebServiceX')
                            ->setMethods(array('getResponseContent'))
                            ->getMock();

        $stubService->expects($this->once())
                    ->method('getResponseContent')
                    ->willReturn($stubResponse);

        $stubService->getExchangeRate();
    }
}