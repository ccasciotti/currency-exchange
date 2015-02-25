<?php

namespace CurrencyExchangeTest;

use CurrencyExchange\HttpClient;

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
		$this->setExpectedException('\InvalidArgumentException');
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
}
