<?php

/**
 * CurrencyExchange
 * 
 * A library to retrieve currency exchanges using several web services
 * 
 * @link https://github.com/teknoman/currency-exchange
 * @license http://www.gnu.org/licenses/gpl-3.0.txt
 */

namespace CurrencyExchange\Currency;

use InvalidArgumentException;

/**
 * Currency class which handles ISO 4217 Currency Code
 * 
 * @package CurrencyExchange
 */
class Currency
{
	/**
	 * @var string
	 */
	protected $_code = null;

	/**
	 * Constructor invokes setCode method
	 * 
	 * @param string $code
	 */
	public function __construct($code)
	{
		$this->setCode($code);
	}

	/**
	 * @return string
	 */
	public function getCode()
	{
		return $this->_code;
	}

	/**
	 * Sets code
	 * 
	 * @param string $code
     * @throws InvalidArgumentException
	 * @return CurrencyExchange\Currency\Currency
	 */
	public function setCode($code)
	{
        if (!$this->isFormatValid($code)) {
			throw new InvalidArgumentException('Currency code must have exactly 3 characters, according to ISO 4217 standard');
		}

        $this->_code = strtoupper((string) $code);
		return $this;
	}

    /**
     * Check if currency code supplied is valid, having exactly 3 uppercase characters
     * 
     * @param string $code
     * @return bool
     */
    public function isFormatValid($code)
    {
        return preg_match('/^[A-Z]{3}$/', strtoupper((string) $code));
    }
}
