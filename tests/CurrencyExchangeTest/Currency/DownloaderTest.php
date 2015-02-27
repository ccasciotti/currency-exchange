<?php

namespace CurrencyExchangeTest\Currency;

use CurrencyExchange\Currency\Downloader;
use Zend\Json\Json;

class DownloaderTest extends \PHPUnit_Framework_TestCase
{
    public function testSetCurrencyDatabaseUriThrowsRuntimeExceptionWhenPassingMalformedUri()
    {
        $this->setExpectedException('RuntimeException');

        $downloader = new Downloader();
        $downloader->setCurrencyDatabaseUri('malformed-uri');
    }

    public function testSetCurrencyDataSuccessfullyFilterElementsWithWithdrawalDate()
    {
        $element1 = new \stdClass();
        $element1->Name = 'Currency1';
        $element1->WithdrawalDate = '2015-01-01';
        
        $element2 = new \stdClass();
        $element2->Name = 'Currency2';

        $element3 = new \stdClass();
        $element3->Name = 'Currency3';
        
        $data = Json::encode(array($element1, $element2, $element3));
        $downloader = new Downloader();
        $downloader->setCurrencyData($data);
        
        $this->assertArraySubset(array($element2, $element3), Json::decode($downloader->getCurrencyData()));
    }

    public function testSetCurrencyDataAvoidFilterElementsWithWithdrawalDateWhenFilterFlagIsFalse()
    {
        $element1 = new \stdClass();
        $element1->Name = 'Currency1';
        $element1->WithdrawalDate = '2015-01-01';

        $element2 = new \stdClass();
        $element2->Name = 'Currency2';

        $element3 = new \stdClass();
        $element3->Name = 'Currency3';

        $originalData = array($element1, $element2, $element3);
        $data = Json::encode($originalData);

        // Set filter flag to false
        $downloader = new Downloader(false);
        $downloader->setCurrencyData($data);

        $this->assertEquals($originalData, Json::decode($downloader->getCurrencyData()));
    }
}