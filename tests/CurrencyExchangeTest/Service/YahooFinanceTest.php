<?php

namespace CurrencyExchangeTest\Service;

class YahooFinanceTest extends \PHPUnit_Framework_TestCase
{
    public function testGetExchangeRateReturnCorrectRate()
    {
        $response = 'firstcolumn,1.23,thirdcolumn';

        $stubResponse = $this->getMockBuilder('\GuzzleHttp\Message\Response')
                             ->setConstructorArgs(array(200))
                             ->setMethods(array('getBody'))
                             ->getMock();

        $stubResponse->expects($this->any())
                     ->method('getBody')
                     ->willReturn($response);

        $stubService = $this->getMockBuilder('\CurrencyExchange\Service\YahooFinance')
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

        $response = 'firstcolumn';

        $stubResponse = $this->getMockBuilder('\GuzzleHttp\Message\Response')
                             ->setConstructorArgs(array(200))
                             ->setMethods(array('getBody'))
                             ->getMock();

        $stubResponse->expects($this->any())
                     ->method('getBody')
                     ->willReturn($response);

        $stubService = $this->getMockBuilder('\CurrencyExchange\Service\YahooFinance')
                            ->setMethods(array('getResponseContent'))
                            ->getMock();

        $stubService->expects($this->once())
                    ->method('getResponseContent')
                    ->willReturn($stubResponse);

        $stubService->getExchangeRate();
    }

    public function testGetExchangeRateThrowsParseExceptionWhenRateIsZero()
    {
        $this->setExpectedException('\CurrencyExchange\Exception\ParseException');

        $response = 'firstcolumn,0,thirdcolumn';

        $stubResponse = $this->getMockBuilder('\GuzzleHttp\Message\Response')
                             ->setConstructorArgs(array(200))
                             ->setMethods(array('getBody'))
                             ->getMock();

        $stubResponse->expects($this->any())
                     ->method('getBody')
                     ->willReturn($response);

        $stubService = $this->getMockBuilder('\CurrencyExchange\Service\YahooFinance')
                            ->setMethods(array('getResponseContent'))
                            ->getMock();

        $stubService->expects($this->once())
                    ->method('getResponseContent')
                    ->willReturn($stubResponse);

        $stubService->getExchangeRate();
    }
}
