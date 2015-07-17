<?php

namespace CurrencyExchangeTest;

use CurrencyExchange\HttpClient;
use GuzzleHttp\Message\Response as GuzzleResponse;

class HttpClientTest extends \PHPUnit_Framework_TestCase
{
	public function testSetProxyThrowsInvalidArgumentExceptionWhenPassingMalformedString()
	{
		$this->setExpectedException('\InvalidArgumentException');

        $httpClient = new HttpClient();
		$httpClient->setProxy('malformed-proxy-string');
	}

	public function testSetHttpMethodThrowsInvalidArgumentExceptionWhenPassingUnknownMethod()
	{
		$this->setExpectedException('\RuntimeException');

        $httpClient = new HttpClient();
		$httpClient->setHttpMethod('unknown-method');
	}

	public function testIsHttpGetReturnsTrueIfHttpMethodIsGet()
	{
		$httpClient = new HttpClient();
		$httpClient->setHttpMethod(HttpClient::HTTP_GET);

		$this->assertTrue($httpClient->isHttpGet());
	}

	public function testIsHttpGetReturnsFalseIfHttpMethodIsPost()
	{
		$httpClient = new HttpClient();
		$httpClient->setHttpMethod(HttpClient::HTTP_POST);

		$this->assertFalse($httpClient->isHttpGet());
	}

	public function testIsHttpPostReturnsTrueIfHttpMethodIsPost()
	{
		$httpClient = new HttpClient();
		$httpClient->setHttpMethod(HttpClient::HTTP_POST);

		$this->assertTrue($httpClient->isHttpPost());
	}

	public function testIsHttpPostReturnsFalseIfHttpMethodIsGet()
	{
		$httpClient = new HttpClient();
		$httpClient->setHttpMethod(HttpClient::HTTP_GET);

		$this->assertFalse($httpClient->isHttpPost());
	}

    /**
     * @dataProvider providerTestSetResponseThrowsResponseExceptionWhenRequestIsNotSuccess
     */
    public function testSetResponseThrowsResponseExceptionWhenRequestIsNotSuccess($statusCode)
    {
        $this->setExpectedException('\CurrencyExchange\Exception\ResponseException');

        $fakeResponse = new GuzzleResponse($statusCode);

        $stubHttpClient = new HttpClient();
        $stubHttpClient->setResponse($fakeResponse);
    }

    public function providerTestSetResponseThrowsResponseExceptionWhenRequestIsNotSuccess()
    {
        return array(
            array(100),
            array(300),
            array(400),
            array(500),
        );
    }
}
