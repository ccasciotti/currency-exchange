<?php

namespace CurrencyExchangeTest\Http;

use CurrencyExchange\Http\Request;
use RuntimeException;

class RequestTest extends \PHPUnit\Framework\TestCase
{
    public function testGetHttpMethodIsGetByDefault(): void
    {
        $request = new Request();

        $this->assertTrue($request->isHttpGet());
    }

    public function testGetUserAgentReturnsDefaultUserAgentWhenSetterMethodIsNotInvoked(): void
    {
        $request = new Request();

        $this->assertSame(Request::DEFAULT_USER_AGENT, $request->getUserAgent());
    }

    public function testSetUserAgentReturnsExpectedUserAgentWhenSetterMethodIsInvoked(): void
    {
        $userAgent = 'My User Agent';

        $request = new Request();
        $request->setUserAgent($userAgent);

        $this->assertSame($userAgent, $request->getUserAgent());
    }

	public function testSetHttpMethodThrowsRuntimeExceptionWhenPassingUnknownMethod(): void
    {
		$this->expectException(RuntimeException::class);

        $request = new Request();
		$request->setHttpMethod('unknown-method');
	}

	public function testIsHttpGetReturnsTrueIfHttpMethodIsGet(): void
    {
		$request = new Request();
		$request->setHttpMethod(Request::HTTP_GET);

		$this->assertTrue($request->isHttpGet());
	}

	public function testIsHttpGetReturnsFalseIfHttpMethodIsPost(): void
    {
		$request = new Request();
		$request->setHttpMethod(Request::HTTP_POST);

		$this->assertFalse($request->isHttpGet());
	}

	public function testIsHttpPostReturnsTrueIfHttpMethodIsPost(): void
    {
		$request = new Request();
		$request->setHttpMethod(Request::HTTP_POST);

		$this->assertTrue($request->isHttpPost());
	}

	public function testIsHttpPostReturnsFalseIfHttpMethodIsGet(): void
    {
		$request = new Request();
		$request->setHttpMethod(Request::HTTP_GET);

		$this->assertFalse($request->isHttpPost());
	}

    /**
     * @dataProvider providerTestIsHttpMethodSupportedReturnsTrueIfMethodIsSupported
     */
    public function testIsHttpMethodSupportedReturnsTrueIfMethodIsSupported($httpMethod): void
    {
        $this->assertTrue(Request::isHttpMethodSupported($httpMethod));
    }

    /**
     * @dataProvider providerTestIsHttpMethodSupportedReturnsFalseIfMethodIsUnsupported
     */
    public function testIsHttpMethodSupportedReturnsFalseIfMethodIsUnsupported($httpMethod): void
    {
        $this->assertFalse(Request::isHttpMethodSupported($httpMethod));
    }

    public function providerTestIsHttpMethodSupportedReturnsTrueIfMethodIsSupported(): array
    {
        return [
            [Request::HTTP_GET],
            [Request::HTTP_POST]
        ];
    }

    public function providerTestIsHttpMethodSupportedReturnsFalseIfMethodIsUnsupported(): array
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