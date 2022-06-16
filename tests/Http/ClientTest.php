<?php

namespace CurrencyExchangeTest\Http;

use CurrencyExchange\Http\Client;
use GuzzleHttp\Psr7\Response as GuzzleResponse;
use CurrencyExchange\Exception\ResponseException;
use InvalidArgumentException;

class ClientTest extends \PHPUnit\Framework\TestCase
{
	public function testSetProxyThrowsInvalidArgumentExceptionWhenPassingMalformedString(): void
    {
		$this->expectException(InvalidArgumentException::class);

        $httpClient = new Client();
		$httpClient->setProxy('malformed-proxy-string');
	}

    /**
     * @dataProvider providerTestSetResponseThrowsResponseExceptionWhenRequestIsNotSuccess
     */
    public function testSetResponseThrowsResponseExceptionWhenRequestIsNotSuccess($statusCode): void
    {
        $this->expectException(ResponseException::class);

        $fakeResponse = new GuzzleResponse($statusCode);

        $stubHttpClient = new Client();
        $stubHttpClient->setResponse($fakeResponse);
    }

    public function providerTestSetResponseThrowsResponseExceptionWhenRequestIsNotSuccess()
    {
        return [
            [100],
            [300],
            [400],
            [500],
        ];
    }
}
