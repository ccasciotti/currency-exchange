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
	 * @return CurrencyExchange\Currency\Currency
	 */
	public function setCode($code)
	{
		$this->_code = strtoupper((string) $code);
		return $this;
	}
}
