<?php

namespace CurrencyExchangeTest\Service;

class YahooFinanceTest extends \PHPUnit_Framework_TestCase
{
    public function testGetExchangeRateReturnCorrectRate()
    {
        $response = 'firstcolumn,1.23,thirdcolumn';

        $stubService = $this->getMockBuilder('\CurrencyExchange\Service\YahooFinance')
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

        $response = 'firstcolumn';

        $stubService = $this->getMockBuilder('\CurrencyExchange\Service\YahooFinance')
                            ->setMethods(array('getResponseContent'))
                            ->getMock();

        $stubService->expects($this->once())
                    ->method('getResponseContent')
                    ->willReturn($response);

        $stubService->getExchangeRate();
    }

    public function testGetExchangeRateThrowsParseExceptionWhenRateIsZero()
    {
        $this->setExpectedException('\CurrencyExchange\Exception\ParseException');

        $response = 'firstcolumn,0,thirdcolumn';

        $stubService = $this->getMockBuilder('\CurrencyExchange\Service\YahooFinance')
                            ->setMethods(array('getResponseContent'))
                            ->getMock();

        $stubService->expects($this->once())
                    ->method('getResponseContent')
                    ->willReturn($response);

        $stubService->getExchangeRate();
    }
}
