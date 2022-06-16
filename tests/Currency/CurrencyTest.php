<?php

namespace CurrencyExchangeTest\Currency;

use CurrencyExchange\Currency\Currency;
use InvalidArgumentException;

class CurrencyTest extends \PHPUnit\Framework\TestCase
{
	public function testSetCodeSetCodeWithThreeUppercaseCharacters(): void
    {
		$currency = new Currency('eur');

        $this->assertMatchesRegularExpression('/[A-Z]{3}/', $currency->getCode());
	}

    public function testCurrencyWithoutThreeCharactersThrowsInvalidArgumentException(): void
    {
		$this->expectException(InvalidArgumentException::class);

		new Currency('ab');
	}
}
