<?php

namespace CurrencyExchange\Uri;

use CurrencyExchange\Exception;

/**
 * Abstract Uri class, it contains commons methods for each uri type
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
	 * @var string In the format of 3 character
	 */
	protected $_fromCurrency = null;

	/**
	 * @var string In the format of 3 character
	 */
	protected $_toCurrency = null;

	/**
	 * Constructor invokes setType method
	 * 
	 * @param string $type
	 * @return void
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

		if (!in_array($type, array('GET', 'POST')))
			throw new Exception\InvalidArgumentException('Uri type must be GET or POST, ' . $type . ' given');

		$this->_type = $type;
		return $this;
	}

	/**
	 * Checks if currency code supplied is in the right format
	 * 
	 * @param string $code
	 * @return boolean
	 */
	protected function _checkCurrencyCode($code)
	{
		return preg_match('/^[A-Z]{3}$/', (string) $code);
	}

	/**
	 * Set "From Currency" code
	 * 
	 * @param string $code
	 * @throws CurrencyExchange\Exception\InvalidArgumentException
	 * @return CurrencyExchange\Uri\AbstractUri
	 */
	public function setFromCurrency($code)
	{
		$code = (string) $code;

		if (!$this->_checkCurrencyCode($code))
			throw new Exception\InvalidArgumentException('"From Currency" must have exactly 3 uppercase characters');

		$this->_fromCurrency = $code;
		return $this;
	}

	/**
	 * Set "To Currency" code
	 * 
	 * @param string $code
	 * @throws CurrencyExchange\Exception\InvalidArgumentException
	 * @return CurrencyExchange\Uri\AbstractUri
	 */
	public function setToCurrency($code)
	{
		$code = (string) $code;

		if (!$this->_checkCurrencyCode($code))
			throw new Exception\InvalidArgumentException('"To Currency" must have exactly 3 uppercase characters');

		$this->_toCurrency = $code;
		return $this;
	}
}
