<?php

namespace CurrencyExchangeTest\Factory;

use CurrencyExchange\Factory\UriFactory;
use CurrencyExchange\Http\Request;
use CurrencyExchange\Uri\GetUri;
use CurrencyExchange\Uri\PostUri;
use InvalidArgumentException;

class UriFactoryTest extends \PHPUnit\Framework\TestCase
{
    public function testUriFactoryThrowsInvalidArgumentExceptionWhenPassingInvalidUriType(): void
    {
        $this->expectException(InvalidArgumentException::class);

        UriFactory::create('unknown-uri-type');
    }

	/**
	 * @dataProvider providerTestUriFactoryReturnsInstanceOfUriAbstract
	 */
	public function testUriFactoryReturnsInstanceOfRightUriObject($uriType): void
    {
		$instance = UriFactory::create($uriType);

        switch ($uriType) {
            case Request::HTTP_GET:
                $this->assertInstanceOf(GetUri::class, $instance);
                break;
            case Request::HTTP_POST:
                $this->assertInstanceOf(PostUri::class, $instance);
                break;
        }
	}

	public function providerTestUriFactoryReturnsInstanceOfUriAbstract(): array
    {
		return [
            [Request::HTTP_GET],
			[Request::HTTP_POST],
        ];
	}
}
