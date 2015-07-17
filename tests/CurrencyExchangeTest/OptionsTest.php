<?php

namespace CurrencyExchangeTest;

use CurrencyExchange\Options;

class OptionsTest extends \PHPUnit_Framework_TestCase
{
    public function testAddOptionSuccessfullySetOption()
    {
        $options = new Options();
        $options->add('my-option', 'my-option-value');

        $this->assertEquals('my-option-value', $options->get('my-option'));
    }

    public function testAddOptionWithReplaceFlagTrueSuccessfullyOverrideOption()
    {
        $options = new Options();
        $options->add('my-option', 'my-option-value');
        $options->add('my-option', 'my-overrided-value', true);

        $this->assertEquals('my-overrided-value', $options->get('my-option'));
    }

    public function testAddOptionWithoutReplaceFlagIgnoreOverridedOption()
    {
        $options = new Options();
        $options->add('my-option', 'my-option-value');
        $options->add('my-option', 'my-overrided-value');

        $this->assertEquals('my-option-value', $options->get('my-option'));
    }

    public function testAddOptionThrowsInvalidArgumentExceptionPassingNonScalarValue()
    {
        $this->setExpectedException('InvalidArgumentException');

        $options = new Options();
        $options->add([], 'option-value');
    }

    public function testGetOptionThrowsInvalidArgumentExceptionPassingNonScalarValue()
    {
        $this->setExpectedException('InvalidArgumentException');

        $options = new Options();
        $options->get([]);
    }

    public function testGetOptionReturnFalsePassingInexistentOption()
    {
        $options = new Options();
        $value = $options->get('my-option');

        $this->assertNull($value);
    }

    public function testRemoveOptionSuccessfullyUnsetOption()
    {
        $options = new Options();
        $options->add('my-option', 'my-option-value');
        $options->remove('my-option');
        $value = $options->get('my-option');

        $this->assertNull($value);
    }

    public function testRemoveOptionThrowsInvalidArgumentExceptionPassingNonScalarValue()
    {
        $this->setExpectedException('InvalidArgumentException');

        $options = new Options();
        $options->remove([]);
    }

    public function testGetOptionsReturnsArrayAndIsFilled()
    {
        $opts = [
            'key1' => 'value1',
            'key2' => 'value2',
        ];

        $options = new Options();
        $options->setOptions($opts);

        $this->assertTrue(is_array($options->getAll()));
        $this->assertNotEmpty($options->getAll());
    }

    public function testClearReturnsEmptyArray()
    {
        $opts = [
            'key1' => 'value1',
            'key2' => 'value2',
        ];

        $options = new Options();
        $options->setOptions($opts);
        $options->clear();

        $this->assertTrue(is_array($options->getAll()));
        $this->assertEmpty($options->getAll());
    }

    public function testSetOptionsIgnoringExistentValuesWhenPassingFalseAsSecondParameter()
    {
        $opts = [
            'key1' => 'value1',
            'key2' => 'value2',
        ];

        $options = new Options();
        $options->setOptions($opts);

        $options->setOptions([
            'key1' => 'overrided-value1',
            'key3' => 'value3',
        ]);

        $this->assertEquals('value1', $options->get('key1'));
        $this->assertEquals('value3', $options->get('key3'));
    }

    public function testSetOptionsOverrideExistentValuesWhenPassingTrueAsSecondParameter()
    {
        $opts = [
            'key1' => 'value1',
            'key2' => 'value2',
        ];

        $options = new Options();
        $options->setOptions($opts);

        $options->setOptions([
            'key1' => 'overrided-value1',
            'key3' => 'value3',
        ], true);

        $this->assertEquals('overrided-value1', $options->get('key1'));
        $this->assertEquals('value3', $options->get('key3'));
    }
}