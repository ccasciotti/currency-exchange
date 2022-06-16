<?php

declare(strict_types=1);

namespace CurrencyExchangeTest\Uri;

use CurrencyExchange\Uri\PostUri;
use CurrencyExchange\Http\Request;
use CurrencyExchange\Currency\Currency;
use InvalidArgumentException;

class PostUriTest extends \PHPUnit\Framework\TestCase
{
    public function testGetFinalUriThrowsInvalidArgumentExceptionWithoutTemplateUriSet(): void
    {
        $this->expectException(InvalidArgumentException::class);

        $uriGet = new PostUri(Request::HTTP_POST);
        $uriGet->setFromCurrency(new Currency('EUR'));
        $uriGet->setToCurrency(new Currency('USD'));
        $uriGet->getFinalUri();
    }

    public function testGetFinalUriThrowsInvalidArgumentExceptionWithoutFromCurrencySet(): void
    {
        $this->expectException(InvalidArgumentException::class);

        $templateUri = 'http://my.template.uri/';

        $uriGet = new PostUri(Request::HTTP_POST);
        $uriGet->setTemplateUri($templateUri);
        $uriGet->setToCurrency(new Currency('USD'));
        $uriGet->getFinalUri();
    }

    public function testGetFinalUriThrowsInvalidArgumentExceptionWithoutToCurrencySet(): void
    {
        $this->expectException(InvalidArgumentException::class);

        $templateUri = 'http://my.template.uri/';

        $uriGet = new PostUri(Request::HTTP_POST);
        $uriGet->setTemplateUri($templateUri);
        $uriGet->setFromCurrency(new Currency('EUR'));
        $uriGet->getFinalUri();
    }
}