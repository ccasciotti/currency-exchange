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
	 * Sets code in ISO 4217 standard
	 * 
	 * @param string $code
	 * @throws InvalidArgumentException
	 * @return CurrencyExchange\Currency\Currency
	 */
	public function setCode($code)
	{
		$code = (string) $code;

		if (!preg_match('/^[a-z]{3}$/i', $code)) {
			throw new InvalidArgumentException('Currency code must have exactly 3 characters, according to ISO 4217 standard');
		}

		$this->_code = strtoupper($code);
		return $this;
	}
}
