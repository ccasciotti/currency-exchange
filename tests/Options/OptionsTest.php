<?php

namespace CurrencyExchangeTest\Options;

use CurrencyExchange\Options\Options;
use InvalidArgumentException;

class OptionsTest extends \PHPUnit\Framework\TestCase
{
    public function testAddOptionSuccessfullySetOption(): void
    {
        $options = new Options();
        $options->add('my-option', 'my-option-value');

        $this->assertEquals('my-option-value', $options->get('my-option'));
    }

    public function testAddOptionWithReplaceFlagTrueSuccessfullyOverrideOption(): void
    {
        $options = new Options();
        $options->add('my-option', 'my-option-value');
        $options->add('my-option', 'my-overridden-value', true);

        $this->assertEquals('my-overridden-value', $options->get('my-option'));
    }

    public function testAddOptionWithoutReplaceFlagIgnoreOverridedOption(): void
    {
        $options = new Options();
        $options->add('my-option', 'my-option-value');
        $options->add('my-option', 'my-overridden-value');

        $this->assertEquals('my-option-value', $options->get('my-option'));
    }

    public function testAddOptionThrowsInvalidArgumentExceptionPassingNonScalarValue(): void
    {
        $this->expectException(InvalidArgumentException::class);

        $options = new Options();
        $options->add([], 'option-value');
    }

    public function testGetOptionThrowsInvalidArgumentExceptionPassingNonScalarValue(): void
    {
        $this->expectException(InvalidArgumentException::class);

        $options = new Options();
        $options->get([]);
    }

    public function testGetOptionReturnFalsePassingInexistentOption(): void
    {
        $options = new Options();
        $value = $options->get('my-option');

        $this->assertNull($value);
    }

    public function testRemoveOptionSuccessfullyUnsetOption(): void
    {
        $options = new Options();
        $options->add('my-option', 'my-option-value');
        $options->remove('my-option');
        $value = $options->get('my-option');

        $this->assertNull($value);
    }

    public function testRemoveOptionThrowsInvalidArgumentExceptionPassingNonScalarValue(): void
    {
        $this->expectException(InvalidArgumentException::class);

        $options = new Options();
        $options->remove([]);
    }

    public function testGetOptionsReturnsArrayAndIsFilled(): void
    {
        $opts = [
            'key1' => 'value1',
            'key2' => 'value2',
        ];

        $options = new Options();
        $options->setOptions($opts);

        $this->assertIsArray($options->getAll());
        $this->assertNotEmpty($options->getAll());
    }

    public function testClearReturnsEmptyArray(): void
    {
        $opts = [
            'key1' => 'value1',
            'key2' => 'value2',
        ];

        $options = new Options();
        $options->setOptions($opts);
        $options->clear();

        $this->assertIsArray($options->getAll());
        $this->assertEmpty($options->getAll());
    }

    public function testSetOptionsIgnoringExistentValuesWhenPassingFalseAsSecondParameter(): void
    {
        $opts = [
            'key1' => 'value1',
            'key2' => 'value2',
        ];

        $options = new Options();
        $options->setOptions($opts);

        $options->setOptions([
            'key1' => 'overridden-value1',
            'key3' => 'value3',
        ]);

        $this->assertEquals('value1', $options->get('key1'));
        $this->assertEquals('value3', $options->get('key3'));
    }

    public function testSetOptionsOverrideExistentValuesWhenPassingTrueAsSecondParameter(): void
    {
        $opts = [
            'key1' => 'value1',
            'key2' => 'value2',
        ];

        $options = new Options();
        $options->setOptions($opts);

        $options->setOptions([
            'key1' => 'overridden-value1',
            'key3' => 'value3',
        ], true);

        $this->assertEquals('overridden-value1', $options->get('key1'));
        $this->assertEquals('value3', $options->get('key3'));
    }
}