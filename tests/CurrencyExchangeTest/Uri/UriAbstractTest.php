<?php

namespace CurrencyExchangeTest\Uri;

use CurrencyExchange\HttpClient;

class UriAbstractTest extends \PHPUnit_Framework_TestCase
{
    public function testSetTypeThrowsInvalidArgumentExceptionWhenPassingUnknownMethod()
    {
        $this->setExpectedException('InvalidArgumentException');

        $this->getMockForAbstractClass('\CurrencyExchange\Uri\UriAbstract', array('unknown-method'));
    }

    public function testSetTypeSetHttpMethodUppercased()
    {
        $stub1 = $this->getMockForAbstractClass('\CurrencyExchange\Uri\UriAbstract', array(HttpClient::HTTP_GET));
        $stub2 = $this->getMockForAbstractClass('\CurrencyExchange\Uri\UriAbstract', array(HttpClient::HTTP_POST));
        
        $this->assertRegExp('/[A-Z]/', $stub1->getType());
        $this->assertRegExp('/[A-Z]/', $stub2->getType());
    }
}