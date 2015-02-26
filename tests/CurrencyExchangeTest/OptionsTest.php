<?php

namespace CurrencyExchangeTest;

use CurrencyExchange\Options;

class OptionsTest extends \PHPUnit_Framework_TestCase
{
    public function testAddOptionSuccessfullySetOption()
    {
        $options = new Options();
        $options->addOption('my-option', 'my-option-value');

        $this->assertEquals('my-option-value', $options->getOption('my-option'));
    }

    public function testAddOptionWithReplaceFlagTrueSuccessfullyOverrideOption()
    {
        $options = new Options();
        $options->addOption('my-option', 'my-option-value');
        $options->addOption('my-option', 'my-overrided-value', true);

        $this->assertEquals('my-overrided-value', $options->getOption('my-option'));
    }

    public function testAddOptionWithoutReplaceFlagIgnoreOverridedOption()
    {
        $options = new Options();
        $options->addOption('my-option', 'my-option-value');
        $options->addOption('my-option', 'my-overrided-value');

        $this->assertEquals('my-option-value', $options->getOption('my-option'));
    }

    public function testAddOptionThrowsInvalidArgumentExceptionPassingNonScalarValue()
    {
        $this->setExpectedException('InvalidArgumentException');

        $options = new Options();
        $options->addOption(array(), 'option-value');
    }

    public function testGetOptionThrowsInvalidArgumentExceptionPassingNonScalarValue()
    {
        $this->setExpectedException('InvalidArgumentException');

        $options = new Options();
        $options->getOption(array());
    }

    public function testGetOptionReturnFalsePassingInexistentOption()
    {
        $options = new Options();
        $value = $options->getOption('my-option');

        $this->assertFalse($value);
    }

    public function testRemoveOptionSuccessfullyUnsetOption()
    {
        $options = new Options();
        $options->addOption('my-option', 'my-option-value');
        $options->removeOption('my-option');
        $value = $options->getOption('my-option');

        $this->assertFalse($value);
    }

    public function testRemoveOptionThrowsInvalidArgumentExceptionPassingNonScalarValue()
    {
        $this->setExpectedException('InvalidArgumentException');

        $options = new Options();
        $options->removeOption(array());
    }

    public function testGetOptionsReturnsArray()
    {
        $opts = array(
            'key1' => 'value1',
            'key2' => 'value2',
        );

        $options = new Options();
        $options->setOptions($opts);

        $this->assertTrue(is_array($options->getOptions()));
    }

    public function testResetOptionsReturnsEmptyArray()
    {
        $opts = array(
            'key1' => 'value1',
            'key2' => 'value2',
        );

        $options = new Options();
        $options->setOptions($opts);
        $options->resetOptions();

        $this->assertEmpty($options->getOptions());
    }
}