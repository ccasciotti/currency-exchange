<?php

namespace CurrencyExchangeTest\Service;

use Zend\Json\Json;

class GoogleExchangeRateTest extends \PHPUnit_Framework_TestCase
{
    public function testGetExchangeRateReturnCorrectRate()
    {
        $response = new \stdClass();
        $response->rate = 1.23;

        $stubService = $this->getMockBuilder('\CurrencyExchange\Service\GoogleExchangeRate')
                            ->setMethods(array('getResponseContent'))
                            ->getMock();

        $stubService->expects($this->once())
                    ->method('getResponseContent')
                    ->willReturn(Json::encode($response));
        
        $this->assertGreaterThan(0, $stubService->getExchangeRate());
    }

    public function testGetExchangeRateThrowsParseExceptionWhenRateIsNotFound()
    {
        $this->setExpectedException('\CurrencyExchange\Exception\ParseException');

        $response = new \stdClass();
        $response->unknown_node = 1.23;

        $stubService = $this->getMockBuilder('\CurrencyExchange\Service\GoogleExchangeRate')
                            ->setMethods(array('getResponseContent'))
                            ->getMock();

        $stubService->expects($this->once())
                    ->method('getResponseContent')
                    ->willReturn(Json::encode($response));

        $stubService->getExchangeRate();
    }

    public function testGetExchangeRateThrowsParseExceptionWhenRateIsZero()
    {
        $this->setExpectedException('\CurrencyExchange\Exception\ParseException');

        $response = new \stdClass();
        $response->rate = 0;

        $stubService = $this->getMockBuilder('\CurrencyExchange\Service\GoogleExchangeRate')
                            ->setMethods(array('getResponseContent'))
                            ->getMock();

        $stubService->expects($this->once())
                    ->method('getResponseContent')
                    ->willReturn(Json::encode($response));

        $stubService->getExchangeRate();
    }
}