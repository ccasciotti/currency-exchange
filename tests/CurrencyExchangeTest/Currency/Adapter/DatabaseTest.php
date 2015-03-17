<?php

namespace CurrencyExchangeTest\Currency\Adapter;

use CurrencyExchange\Options;
use CurrencyExchange\Currency\Adapter\Database;
use CurrencyExchange\Currency\Adapter\Database\Connection;
use CurrencyExchange\Currency\Adapter\Entity\Currency as CurrencyEntity;
use Zend\Json\Json;

class DatabaseTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var \CurrencyExchange\Currency\Adapter\Database
     */
    private $_database = null;

    /**
     * @var string
     */
    private $_sqlitePath = null;

    protected function setUp()
    {
        $sqlitePath = sys_get_temp_dir() . '/db.sqlite';

        if (!file_exists($sqlitePath)) {
            $this->markTestSkipped('Database not found in ' . $sqlitePath);
        }

        $this->_sqlitePath = $sqlitePath;
        
        $options = new Options();
        $options->addOption('path', $this->_sqlitePath);

        $this->_database = new Database();
        $this->_database->getConnection()->setConnectionType(Connection::DB_CONNECTION_SQLITE);
        $this->_database->getConnection()->setOptions($options);
    }

    protected function tearDown()
    {
        if ($this->_database) {
            $this->_database->emptyTable();
            $this->_database = null;
        }
    }

    public function testSaveDataSuccessfullyFillDatabase()
    {
        $element1 = new CurrencyEntity();
        $element1->setEntity('Currency1');
        $element1->setCurrency('CU1');
        $element1->setAlphabeticCode('CU1');
        $element1->setNumericCode('NUM1');
        $element1->setMinorUnit('MU1');

        $element2 = new CurrencyEntity();
        $element2->setEntity('Currency2');
        $element2->setCurrency('CU2');
        $element2->setAlphabeticCode('CU2');
        $element2->setNumericCode('NUM2');
        $element2->setMinorUnit('MU2');

        $element3 = new CurrencyEntity();
        $element3->setEntity('Currency3');
        $element3->setCurrency('CU3');
        $element3->setAlphabeticCode('CU3');
        $element3->setNumericCode('NUM3');
        $element3->setMinorUnit('MU3');

        $originalData = array($element1, $element2, $element3);
        
        $stubDownloader = $this->getMockBuilder('\CurrencyExchange\Currency\Downloader')
                           ->setMethods(array('makeRequest', 'getCurrencyData'))
                           ->getMock();

        $stubDownloader->expects($this->once())
                   ->method('makeRequest')
                   ->willReturnSelf();

        $stubDownloader->expects($this->once())
                   ->method('getCurrencyData')
                   ->willReturn(Json::encode($originalData));

        $this->_database->setDownloader($stubDownloader);
        $this->_database->saveData();

        foreach ($this->_database->getData() as $currencyElement) {
            $this->assertNotNull($currencyElement->getId());
        }
    }

    public function testSaveDataThrowsRuntimeExceptionWhenCannotEmptyTable()
    {
        $this->setExpectedException('RuntimeException');

        $stubDatabase = $this->getMockBuilder('\CurrencyExchange\Currency\Adapter\Database')
                             ->setMethods(array('emptyTable'))
                             ->getMock();

        $stubDatabase->expects($this->once())
                     ->method('emptyTable')
                     ->willReturn(false);

        $stubDatabase->saveData();
    }
}