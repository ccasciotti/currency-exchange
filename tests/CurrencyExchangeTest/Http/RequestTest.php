<?php

namespace CurrencyExchangeTest\Http;

use CurrencyExchange\Http\Request;

class RequestTest extends \PHPUnit_Framework_TestCase
{
    public function testGetHttpMethodIsGetByDefault()
    {
        $request = new Request();

        $this->assertTrue($request->isHttpGet());
    }

    public function testGetUserAgentReturnsDefaultUserAgentWhenSetterMethodIsNotInvoked()
    {
        $request = new Request();

        $this->assertSame(Request::DEFAULT_USER_AGENT, $request->getUserAgent());
    }

    public function testSetUserAgentReturnsExpectedUserAgentWhenSetterMethodIsInvoked()
    {
        $userAgent = 'My User Agent';

        $request = new Request();
        $request->setUserAgent($userAgent);

        $this->assertSame($userAgent, $request->getUserAgent());
    }

    public function testSetUserAgentThrowsInvalidArgumentExceptionWhenPassingNonStringAsParameter()
    {
        $this->setExpectedException('InvalidArgumentException');

        $request = new Request();
        $request->setUserAgent([]);
    }

    public function testSetHttpMethodThrowsInvalidArgumentExceptionWhenPassingNonStringAsParameter()
	{
		$this->setExpectedException('InvalidArgumentException');

        $request = new Request();
		$request->setHttpMethod([]);
	}

	public function testSetHttpMethodThrowsRuntimeExceptionWhenPassingUnknownMethod()
	{
		$this->setExpectedException('RuntimeException');

        $request = new Request();
		$request->setHttpMethod('unknown-method');
	}

	public function testIsHttpGetReturnsTrueIfHttpMethodIsGet()
	{
		$request = new Request();
		$request->setHttpMethod(Request::HTTP_GET);

		$this->assertTrue($request->isHttpGet());
	}

	public function testIsHttpGetReturnsFalseIfHttpMethodIsPost()
	{
		$request = new Request();
		$request->setHttpMethod(Request::HTTP_POST);

		$this->assertFalse($request->isHttpGet());
	}

	public function testIsHttpPostReturnsTrueIfHttpMethodIsPost()
	{
		$request = new Request();
		$request->setHttpMethod(Request::HTTP_POST);

		$this->assertTrue($request->isHttpPost());
	}

	public function testIsHttpPostReturnsFalseIfHttpMethodIsGet()
	{
		$request = new Request();
		$request->setHttpMethod(Request::HTTP_GET);

		$this->assertFalse($request->isHttpPost());
	}

    /**
     * @dataProvider providerTestIsHttpMethodSupportedReturnsTrueIfMethodIsSupported
     */
    public function testIsHttpMethodSupportedReturnsTrueIfMethodIsSupported($httpMethod)
    {
        $this->assertTrue(Request::isHttpMethodSupported($httpMethod));
    }

    /**
     * @dataProvider providertestIsHttpMethodSupportedReturnsFalseIfMethodIsUnsupported
     */
    public function testIsHttpMethodSupportedReturnsFalseIfMethodIsUnsupported($httpMethod)
    {
        $this->assertFalse(Request::isHttpMethodSupported($httpMethod));
    }

    public function providerTestIsHttpMethodSupportedReturnsTrueIfMethodIsSupported()
    {
        return [
            ['get'],
            ['post']
        ];
    }

    public function providertestIsHttpMethodSupportedReturnsFalseIfMethodIsUnsupported()
    {
        return [
            ['options'],
            ['head'],
            ['put'],
            ['delete'],
            ['trace'],
            ['connect'],
        ];
    }
}