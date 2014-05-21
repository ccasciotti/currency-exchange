<?php

namespace CurrencyExchange;

/**
 * Class used to handle uri of each exchange method
 */
class Uri
{
	/**
	 * @var string The template uri that must be set with the http uri of web service with placeholders
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
	public function getFinalUri()
	{
		if (!$this->_templateUri)
			throw new Exception\InvalidArgumentException('Template Uri not initialized!');

		if (!$this->_fromCurrency)
			throw new Exception\InvalidArgumentException('"From Currency Code" not initialized!');

		if (!$this->_toCurrency)
			throw new Exception\InvalidArgumentException('"To Currency Code" not initialized!');

		$search = array('{%FROMCURRENCY%}', '{%TOCURRENCY%}');
		$replace = array($this->_fromCurrency, $this->_toCurrency);

		$this->_uri = str_replace($search, $replace, $this->_templateUri);

		return $this->_uri;
	}
	
	/**
	 * Set template uri with currency placeholders
	 * @param string $templateUri
	 * @return CurrencyExchange\Uri
	 */
	public function setTemplateUri($templateUri)
	{
		if (strpos($templateUri, '{%FROMCURRENCY%}') === false || strpos($templateUri, '{%TOCURRENCY%}') === false)
			throw new Exception\InvalidArgumentException('Cannot find "From Currency" or "To Currency" placeholders!');

		$this->_templateUri = $templateUri;
		return $this;
	}
	
	/**
	 * Set "From Currency" code
	 * @param string $code
	 * @return CurrencyExchange\Uri
	 */
	public function setFromCurrency($code)
	{
		$this->_fromCurrency = (string) $code;
		return $this;
	}
	
	/**
	 * Set "To Currency" code
	 * @param string $code
	 * @return CurrencyExchange\Uri
	 */
	public function setToCurrency($code)
	{
		$this->_toCurrency = (string) $code;
		return $this;
	}
}
