<?php

namespace CurrencyExchangeTest\Uri;

use CurrencyExchange\Http\Request;

class UriAbstractTest extends \PHPUnit_Framework_TestCase
{
    public function testSetTypeThrowsInvalidArgumentExceptionWhenPassingUnknownMethod()
    {
        $this->setExpectedException('InvalidArgumentException');
        $this->getMockForAbstractClass('\CurrencyExchange\Uri\UriAbstract', ['unknown-method']);
    }

    public function testSetTypeSetHttpMethodUppercased()
    {
        $stub1 = $this->getMockForAbstractClass('\CurrencyExchange\Uri\UriAbstract', [Request::HTTP_GET]);
        $stub2 = $this->getMockForAbstractClass('\CurrencyExchange\Uri\UriAbstract', [Request::HTTP_POST]);
        
        $this->assertRegExp('/[A-Z]/', $stub1->getType());
        $this->assertRegExp('/[A-Z]/', $stub2->getType());
    }
}