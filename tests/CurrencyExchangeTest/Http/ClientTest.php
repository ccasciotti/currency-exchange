<?php

namespace CurrencyExchangeTest\Http;

use CurrencyExchange\Http\Client;
use GuzzleHttp\Message\Response as GuzzleResponse;

class ClientTest extends \PHPUnit_Framework_TestCase
{
    public function testSetProxyThrowsInvalidArgumentExceptionWhenPassingNonStringAsParameter()
	{
		$this->setExpectedException('\InvalidArgumentException');

        $httpClient = new Client();
		$httpClient->setProxy([]);
	}

	public function testSetProxyThrowsInvalidArgumentExceptionWhenPassingMalformedString()
	{
		$this->setExpectedException('\InvalidArgumentException');

        $httpClient = new Client();
		$httpClient->setProxy('malformed-proxy-string');
	}

    /**
     * @dataProvider providerTestSetResponseThrowsResponseExceptionWhenRequestIsNotSuccess
     */
    public function testSetResponseThrowsResponseExceptionWhenRequestIsNotSuccess($statusCode)
    {
        $this->setExpectedException('\CurrencyExchange\Exception\ResponseException');

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
