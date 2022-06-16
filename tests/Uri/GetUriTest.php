<?php

declare(strict_types=1);

namespace CurrencyExchangeTest\Uri;

use CurrencyExchange\Uri\GetUri;
use CurrencyExchange\Http\Request;
use CurrencyExchange\Currency\Currency;
use InvalidArgumentException;

class GetUriTest extends \PHPUnit\Framework\TestCase
{
    public function testSetTemplateUriThrowsInvalidArgumentExceptionWhenPassingMalformedFromCurrencyPlaceholder(): void
    {
        $this->expectException(InvalidArgumentException::class);

        $templateUri = 'http://my.template.uri/FROMCURRENCY/{%TOCURRENCY%}';

        $uriGet = new GetUri(Request::HTTP_GET);
        $uriGet->setTemplateUri($templateUri);
    }

    public function testSetTemplateUriThrowsInvalidArgumentExceptionWhenPassingMalformedToCurrencyPlaceholder(): void
    {
        $this->expectException(InvalidArgumentException::class);

        $templateUri = 'http://my.template.uri/{%FROMCURRENCY%}/TOCURRENCY';

        $uriGet = new GetUri(Request::HTTP_GET);
        $uriGet->setTemplateUri($templateUri);
    }

    public function testGetFinalUriReturnStringWithoutPlaceholders(): void
    {
        $templateUri = 'http://my.template.uri/{%FROMCURRENCY%}/{%TOCURRENCY%}';

        $uriGet = new GetUri(Request::HTTP_GET);
        $uriGet->setTemplateUri($templateUri);
        $uriGet->setFromCurrency(new Currency('EUR'));
        $uriGet->setToCurrency(new Currency('USD'));
        
        $this->assertDoesNotMatchRegularExpression('/{%FROMCURRENCY%}/', $uriGet->getFinalUri());
        $this->assertDoesNotMatchRegularExpression('/{%TOCURRENCY%}/', $uriGet->getFinalUri());
    }

    public function testGetFinalUriThrowsInvalidArgumentExceptionWithoutTemplateUriSet(): void
    {
        $this->expectException(InvalidArgumentException::class);

        $uriGet = new GetUri(Request::HTTP_GET);
        $uriGet->setFromCurrency(new Currency('EUR'));
        $uriGet->setToCurrency(new Currency('USD'));
        $uriGet->getFinalUri();
    }
    
    public function testGetFinalUriThrowsInvalidArgumentExceptionWithoutFromCurrencySet(): void
    {
        $this->expectException(InvalidArgumentException::class);

        $templateUri = 'http://my.template.uri/{%FROMCURRENCY%}/{%TOCURRENCY%}';

        $uriGet = new GetUri(Request::HTTP_GET);
        $uriGet->setTemplateUri($templateUri);
        $uriGet->setToCurrency(new Currency('USD'));
        $uriGet->getFinalUri();
    }

    public function testGetFinalUriThrowsInvalidArgumentExceptionWithoutToCurrencySet(): void
    {
        $this->expectException(InvalidArgumentException::class);

        $templateUri = 'http://my.template.uri/{%FROMCURRENCY%}/{%TOCURRENCY%}';

        $uriGet = new GetUri(Request::HTTP_GET);
        $uriGet->setTemplateUri($templateUri);
        $uriGet->setFromCurrency(new Currency('EUR'));
        $uriGet->getFinalUri();
    }
}