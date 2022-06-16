<?php

namespace CurrencyExchangeTest\Service;

use CurrencyExchange\Exception\ParseException;
use CurrencyExchange\Service\GrandTrunk;
use GuzzleHttp\Psr7\Response;
use GuzzleHttp\Psr7\Stream;

class GrandTrunkTest extends \PHPUnit\Framework\TestCase
{
    public function testGetExchangeRateReturnCorrectRate(): void
    {
        $stubStream = $this
            ->getMockBuilder(Stream::class)
            ->disableOriginalConstructor()
            ->onlyMethods(['getContents'])
            ->getMock()
        ;

        $stubStream
            ->method('getContents')
            ->willReturn('1.23')
        ;

        $stubResponse = $this
            ->getMockBuilder(Response::class)
            ->setConstructorArgs([200])
            ->onlyMethods(['getBody'])
            ->getMock()
        ;

        $stubResponse
            ->method('getBody')
            ->willReturn($stubStream)
        ;

        $stubService = $this
            ->getMockBuilder(GrandTrunk::class)
            ->onlyMethods(['getResponseContent'])
            ->getMock()
        ;

        $stubService
            ->expects($this->once())
            ->method('getResponseContent')
            ->willReturn($stubResponse)
        ;

        $this->assertEquals(1.23, $stubService->getExchangeRate());
    }

    public function testGetExchangeRateThrowsParseExceptionWhenRateIsNotFound(): void
    {
        $this->expectException(ParseException::class);

        $stubStream = $this
            ->getMockBuilder(Stream::class)
            ->disableOriginalConstructor()
            ->onlyMethods(['getContents'])
            ->getMock()
        ;

        $stubStream
            ->method('getContents')
            ->willReturn('')
        ;

        $stubResponse = $this
            ->getMockBuilder(Response::class)
            ->setConstructorArgs([200])
            ->onlyMethods(['getBody'])
            ->getMock()
        ;

        $stubResponse
            ->method('getBody')
            ->willReturn($stubStream)
        ;

        $stubService = $this
            ->getMockBuilder(GrandTrunk::class)
            ->onlyMethods(['getResponseContent'])
            ->getMock()
        ;

        $stubService
            ->expects($this->once())
            ->method('getResponseContent')
            ->willReturn($stubResponse)
        ;

        $stubService->getExchangeRate();
    }
}