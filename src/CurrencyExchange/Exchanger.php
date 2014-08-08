<?php

/**
 * CurrencyExchange
 * 
 * A Module for Zend Framework 2 to retrieve current value exchanges using several web services
 * 
 * @link https://github.com/teknoman/currency-exchange
 * @license http://www.gnu.org/licenses/gpl-3.0.txt
 */

namespace CurrencyExchange;

/**
 * Class that retrieve exchange rates from the current web service set
 * 
 * @package CurrencyExchange
 */
class Exchanger
{
	/**
	 * @var CurrencyExchange\Methods\MethodAbstract Current exchange method
	 */
	protected $_method = null;

	/**
	 * Constructor invokes setMethod
	 * 
	 * @param object|string|null $method The exchange method used for getting exchange rate. If null, it will be used the default exchange method class
	 */
	public function __construct($method = null)
	{
		$this->setMethod($method);
	}

	/**
	 * Returns method object
	 * 
	 * @return CurrencyExchange\Methods\MethodAbstract
	 */
	public function getMethod()
	{
		return $this->_method;
	}

	/**
	 * Invokes factory method to instantiates a new Exchange Method object
	 * 
	 * @param object|string|null $method The exchange method used for getting exchange rate. If null, it will be used the default exchange method class
	 * @return CurrencyExchange\Exchanger
	 */
	public function setMethod($method = null)
	{
		$this->_method = Service\MethodFactory::factory($method);
		return $this;
	}

	/**
	 * Set proxy to HttpClient object
	 * 
	 * @param string $proxy The proxy string in form host:port
	 * @return CurrencyExchange\Exchanger
	 */
	public function setProxy($proxy)
	{
		$this->_method->getHttpClient()->setProxy($proxy);
		return $this;
	}

	/**
	 * Get current exchange rate of selected method
	 * 
	 * @param string $fromCode Currency code according to the format of 3 uppercase characters
	 * @param string $toCode Currency code according to the format of 3 uppercase characters
	 * @return float
	 */
	public function getExchangeRate($fromCode, $toCode)
	{
		$this->_method
			->getUri()
			->setFromCurrency(new Currency($fromCode))
			->setToCurrency(new Currency($toCode));

		return $this->_method->getExchangeRate();
	}

	/**
	 * Retrieve the exchange rate, and it multiplies to the $amount parameter.
	 * 
	 * @param float $amount The amount to exchange
	 * @param string $fromCode Currency code according to the format of 3 uppercase characters
	 * @param string $toCode Currency code according to the format of 3 uppercase characters
	 * @return float
	 */
	public function exchange($amount, $fromCode, $toCode)
	{
		return (float) $this->getExchangeRate($fromCode, $toCode) * (float) $amount;
	}
}
