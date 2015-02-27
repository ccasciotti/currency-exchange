<?php

namespace CurrencyExchangeTest\Uri;

use CurrencyExchange\Uri\UriGet;
use CurrencyExchange\HttpClient;
use CurrencyExchange\Currency\Currency;

class UriGetTest extends \PHPUnit_Framework_TestCase
{
    public function testSetTemplateUriThrowsInvalidArgumentExceptionWhenPassingMalformedFromCurrencyPlaceholder()
    {
        $this->setExpectedException('InvalidArgumentException');

        $templateUri = 'http://my.template.uri/FROMCURRENCY/{%TOCURRENCY%}';
        $uriGet = new UriGet(HttpClient::HTTP_GET);
        $uriGet->setTemplateUri($templateUri);
    }

    public function testSetTemplateUriThrowsInvalidArgumentExceptionWhenPassingMalformedToCurrencyPlaceholder()
    {
        $this->setExpectedException('InvalidArgumentException');

        $templateUri = 'http://my.template.uri/{%FROMCURRENCY%}/TOCURRENCY';
        $uriGet = new UriGet(HttpClient::HTTP_GET);
        $uriGet->setTemplateUri($templateUri);
    }

    public function testGetFinalUriReturnStringWithoutPlaceholders()
    {
        $templateUri = 'http://my.template.uri/{%FROMCURRENCY%}/{%TOCURRENCY%}';
        $uriGet = new UriGet(HttpClient::HTTP_GET);
        $uriGet->setTemplateUri($templateUri);
        $uriGet->setFromCurrency(new Currency('EUR'));
        $uriGet->setToCurrency(new Currency('USD'));
        
        $this->assertNotRegExp('/{%FROMCURRENCY%}/', $uriGet->getFinalUri());
        $this->assertNotRegExp('/{%TOCURRENCY%}/', $uriGet->getFinalUri());
    }

    public function testGetFinalUriThrowsInvalidArgumentExceptionWithoutTemplateUriSet()
    {
        $this->setExpectedException('InvalidArgumentException');

        $uriGet = new UriGet(HttpClient::HTTP_GET);
        $uriGet->setFromCurrency(new Currency('EUR'));
        $uriGet->setToCurrency(new Currency('USD'));
        $uriGet->getFinalUri();
    }
    
    public function testGetFinalUriThrowsInvalidArgumentExceptionWithoutFromCurrencySet()
    {
        $this->setExpectedException('InvalidArgumentException');

        $templateUri = 'http://my.template.uri/{%FROMCURRENCY%}/{%TOCURRENCY%}';
        $uriGet = new UriGet(HttpClient::HTTP_GET);
        $uriGet->setTemplateUri($templateUri);
        $uriGet->setToCurrency(new Currency('USD'));
        $uriGet->getFinalUri();
    }

    public function testGetFinalUriThrowsInvalidArgumentExceptionWithoutToCurrencySet()
    {
        $this->setExpectedException('InvalidArgumentException');

        $templateUri = 'http://my.template.uri/{%FROMCURRENCY%}/{%TOCURRENCY%}';
        $uriGet = new UriGet(HttpClient::HTTP_GET);
        $uriGet->setTemplateUri($templateUri);
        $uriGet->setFromCurrency(new Currency('EUR'));
        $uriGet->getFinalUri();
    }
}