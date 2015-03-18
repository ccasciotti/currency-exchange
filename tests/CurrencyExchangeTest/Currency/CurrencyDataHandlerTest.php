<?php

namespace CurrencyExchangeTest\Currency;

use CurrencyExchange\Currency\Adapter\Entity\Currency as CurrencyExchange;

class CurrencyDataHandlerTest extends \PHPUnit_Framework_TestCase
{
	public function testDefaultAdapterIsInstanceOfAdapterFile()
	{
		$currencyDataHandler = $this->getObject();
		$this->assertInstanceOf('\CurrencyExchange\Currency\Adapter\File', $currencyDataHandler->getAdapter());
	}

    public function testIsValidReturnTrueIfCurrencyIsFoundInDefaultAdapterData()
    {
        $adapterDataElement = new CurrencyExchange();
        $adapterDataElement->setAlphabeticCode('EUR');

        $stubAdapter = $this->getMockBuilder('\CurrencyExchange\Currency\Adapter\File')
                            ->setMethods(array('getData'))
                            ->getMock();

        $stubAdapter->expects($this->once())
                    ->method('getData')
                    ->willReturn(array($adapterDataElement));
        
        $stubCurrencyDataHandler = $this->getMockBuilder('\CurrencyExchange\Currency\CurrencyDataHandler')
                                        ->setMethods(array('getAdapter'))
                                        ->getMock();

        $stubCurrencyDataHandler->expects($this->once())
                                ->method('getAdapter')
                                ->willReturn($stubAdapter);
        
        $this->assertTrue($stubCurrencyDataHandler->isValid('EUR'));
    }

    public function testIsValidReturnFalseIfCurrencyIsNotFoundInDefaultAdapterData()
    {
        $adapterDataElement = new CurrencyExchange();
        $adapterDataElement->setAlphabeticCode('EUR');

        $stubAdapter = $this->getMockBuilder('\CurrencyExchange\Currency\Adapter\File')
                            ->setMethods(array('getData'))
                            ->getMock();

        $stubAdapter->expects($this->once())
                    ->method('getData')
                    ->willReturn(array($adapterDataElement));
        
        $stubCurrencyDataHandler = $this->getMockBuilder('\CurrencyExchange\Currency\CurrencyDataHandler')
                                        ->setMethods(array('getAdapter'))
                                        ->getMock();

        $stubCurrencyDataHandler->expects($this->once())
                                ->method('getAdapter')
                                ->willReturn($stubAdapter);
        
        $this->assertFalse($stubCurrencyDataHandler->isValid('USD'));
    }

    private function getObject()
	{
		return new \CurrencyExchange\Currency\CurrencyDataHandler();
	}
}
