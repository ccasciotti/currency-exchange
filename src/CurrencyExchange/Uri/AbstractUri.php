<?php

/**
 * CurrencyExchange
 * 
 * A Module for Zend Framework 2 to retrieve current value exchanges using several web services
 * 
 * @link https://github.com/teknoman/currency-exchange
 * @license http://www.gnu.org/licenses/gpl-3.0.txt
 */

namespace CurrencyExchange\Uri;

use CurrencyExchange\Currency;
use CurrencyExchange\HttpClient;
use CurrencyExchange\Exception;

/**
 * Abstract Uri class, it contains commons methods for each uri type
 * 
 * @package CurrencyExchange
 * @subpackage Uri
 */
abstract class AbstractUri
{
	/**
	 * @var string The template uri that must be set with the http uri of web service
	 */
	protected $_templateUri = null;

	/**
	 * @var string The final uri with the $_fromCurrency and $_toCurrency set
	 */
	protected $_uri = null;

	/**
	 * @var string Http type for this Uri (GET or POST)
	 */
	protected $_type = null;

	/**
	 * @var CurrencyExchange\Currency
	 */
	protected $_fromCurrency = null;

	/**
	 * @var CurrencyExchange\Currency
	 */
	protected $_toCurrency = null;

	/**
	 * Constructor invokes setType method
	 * 
	 * @param string $type
	 */
	public function __construct($type)
	{
		$this->setType($type);
	}

	/**
	 * Returns the final uri with currency codes set
	 * 
	 * @return string
	 */
	abstract public function getFinalUri();

	/**
	 * Set template uri with currency placeholders (if uri type is GET)
	 * 
	 * @param string $templateUri
	 * @return CurrencyExchange\Uri\AbstractUri
	 */
	abstract public function setTemplateUri($templateUri);

	/**
	 * @return string
	 */
	public function getType()
	{
		return $this->_type;
	}

	/**
	 * @return string
	 */
	public function getFromCurrency()
	{
		return $this->_fromCurrency;
	}

	/**
	 * @return string
	 */
	public function getToCurrency()
	{
		return $this->_toCurrency;
	}

	/**
	 * Sets the type of this Uri, can be GET or POST
	 * 
	 * @param string $type Uri type, can be GET or POST
	 * @throws CurrencyExchange\Exception\InvalidArgumentException
	 * @return CurrencyExchange\Uri\AbstractUri
	 */
	public function setType($type)
	{
		$type = strtoupper((string) $type);

		if (!in_array($type, array(HttpClient::HTTP_GET, HttpClient::HTTP_POST))) {
			throw new Exception\InvalidArgumentException('Uri type must be GET or POST, ' . $type . ' given');
		}

		$this->_type = $type;
		return $this;
	}

	/**
	 * Set "From Currency" object
	 * 
	 * @param CurrencyExchange\Currency $currency
	 * @return CurrencyExchange\Uri\AbstractUri
	 */
	public function setFromCurrency(Currency $currency)
	{
		$this->_fromCurrency = $currency;
		return $this;
	}

	/**
	 * Set "To Currency" object
	 * 
	 * @param CurrencyExchange\Currency $currency
	 * @return CurrencyExchange\Uri\AbstractUri
	 */
	public function setToCurrency(Currency $currency)
	{
		$this->_toCurrency = $currency;
		return $this;
	}
}
