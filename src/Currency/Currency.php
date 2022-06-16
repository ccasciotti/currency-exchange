<?php

declare(strict_types=1);

/**
 * CurrencyExchange
 * 
 * A library to retrieve currency exchanges using several web services
 * 
 * @link https://github.com/ccasciotti/currency-exchange
 * @license http://www.gnu.org/licenses/gpl-3.0.txt
 */

namespace CurrencyExchange\Currency;

use InvalidArgumentException;

/**
 * Currency class which handles ISO 4217 Currency Code
 * 
 * @package CurrencyExchange
 */
final class Currency
{
	/**
	 * @var string|null
	 */
	protected ?string $code = null;

	/**
	 * Constructor invokes setCode method
	 * 
	 * @param string $code
	 */
	public function __construct(string $code)
	{
		$this->setCode($code);
	}

	/**
	 * @return string
	 */
	public function getCode(): string
    {
		return $this->code;
	}

	/**
	 * Sets code
	 * 
	 * @param string $code
	 * @return $this
     * @throws InvalidArgumentException
	 */
	public function setCode(string $code): Currency
    {
        if (!$this->isFormatValid($code)) {
			throw new InvalidArgumentException('Currency code must have exactly 3 characters, according to ISO 4217 standard');
		}

        $this->code = strtoupper($code);
		return $this;
	}

    /**
     * Check if currency code supplied is valid, having exactly 3 uppercase characters
     * 
     * @param string $code
     * @return bool
     */
    public function isFormatValid(string $code): bool
    {
        return (bool) preg_match('/^[a-z]{3}$/i', $code);
    }
}
