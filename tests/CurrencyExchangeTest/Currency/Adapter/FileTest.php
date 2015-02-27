<?php

namespace CurrencyExchangeTest\Currency\Adapter;

use CurrencyExchange\Currency\Adapter\File;
use Zend\Json\Json;

class FileTest extends \PHPUnit_Framework_TestCase
{
    public function testGetFullPathReturnDifferentPathWhenAlternativePathIsSet()
    {
        $file1 = new File();

        $file2 = new File();
        $file2->setDataDirectory('/my-alternative-data-directory');
        $file2->setDataFilename('my-alternative-filename');

        $this->assertNotEquals($file1->getFullPath(), $file2->getFullPath());
    }

    public function testGetFullPathReturnAsExpectedWhenAlternativePathIsSet()
    {
        $file = new File();
        $file->setDataDirectory('my-alternative-data-directory');
        $file->setDataFilename('my-alternative-filename');

        $this->assertEquals(
            'my-alternative-data-directory' . DIRECTORY_SEPARATOR . 'my-alternative-filename', 
            $file->getFullPath()
        );
    }

    public function testGetDataThrowsRuntimeExceptionWhenFullPathIsNotReadable()
    {
        $this->setExpectedException('RuntimeException');

        $file = new File();
        $file->setDataDirectory('my-alternative-data-directory');
        $file->setDataFilename('my-alternative-filename');
        $file->getData();
    }

    public function testSaveDataThrowsRuntimeExceptionWhenDirectoryIsNotWritable()
    {
        $this->setExpectedException('RuntimeException');

        $file = new File();
        $file->setDataDirectory('my-alternative-data-directory');
        $file->setDataFilename('my-alternative-filename');
        $file->saveData();
    }

    public function testSaveDataThrowsRuntimeExceptionWhenDownloaderIsNotSet()
    {
        $this->setExpectedException('RuntimeException');

        $file = new File();
        $file->saveData();
    }

    public function testSaveDataSuccessfullyCreatesFilenameWithExpectedContent()
    {
        $element1 = new \stdClass();
        $element1->Name = 'Currency1';
        
        $element2 = new \stdClass();
        $element2->Name = 'Currency2';

        $element3 = new \stdClass();
        $element3->Name = 'Currency3';

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
        
        $tempFileName = tempnam(sys_get_temp_dir(), 'TMP');

        $file = new File();
        $file->setDownloader($stubDownloader);
        $file->setDataDirectory(sys_get_temp_dir());
        $file->setDataFilename(basename($tempFileName));
        $file->saveData();

        $this->assertFileExists($tempFileName);
        $this->assertEquals($originalData, $file->getData());
    }
}