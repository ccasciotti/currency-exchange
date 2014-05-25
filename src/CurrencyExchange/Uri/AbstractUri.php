<?php

namespace CurrencyExchange\Uri;

use CurrencyExchange\Exception;

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
	 * @var string In the format of 3 character
	 */
	protected $_fromCurrency = null;

	/**
	 * @var string In the format of 3 character
	 */
	protected $_toCurrency = null;

	/**
	 * Returns the final uri with currency codes set
	 * @return string
	 */
	abstract public function getFinalUri();

	/**
	 * Set template uri with currency placeholders
	 * @param string $templateUri
	 * @return CurrencyExchange\Uri\AbstractUri
	 */
	abstract public function setTemplateUri($templateUri);

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
	 * Set "From Currency" code
	 * @param string $code
	 * @return CurrencyExchange\Uri\AbstractUri
	 */
	public function setFromCurrency($code)
	{
		$code = (string) $code;

		if (!preg_match('/^[A-Z]{3}$/', $code))
			throw new Exception\InvalidArgumentException('"From Currency" must have exactly 3 uppercase characters');

		$this->_fromCurrency = $code;
		return $this;
	}

	/**
	 * Set "To Currency" code
	 * @param string $code
	 * @return CurrencyExchange\Uri\AbstractUri
	 */
	public function setToCurrency($code)
	{
		$code = (string) $code;

		if (!preg_match('/^[A-Z]{3}$/', $code))
			throw new Exception\InvalidArgumentException('"To Currency" must have exactly 3 uppercase characters');

		$this->_toCurrency = $code;
		return $this;
	}
}
