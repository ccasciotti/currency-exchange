<?php

namespace CurrencyExchange\Uri;

use CurrencyExchange\Exception;

/**
 * Class used to handle uri of each exchange method that uses uri with Http GET mode
 */
class UriGet extends AbstractUri
{
	/**
	 * Returns the final uri with currency codes set
	 * @return string
	 */
	public function getFinalUri()
	{
		if (!$this->_templateUri)
			throw new Exception\InvalidArgumentException('Template Uri not set');

		if (!$this->_fromCurrency)
			throw new Exception\InvalidArgumentException('"From Currency Code" not set');

		if (!$this->_toCurrency)
			throw new Exception\InvalidArgumentException('"To Currency Code" not set');

		$search = array('{%FROMCURRENCY%}', '{%TOCURRENCY%}');
		$replace = array($this->_fromCurrency, $this->_toCurrency);

		$this->_uri = str_replace($search, $replace, $this->_templateUri);

		return $this->_uri;
	}

	/**
	 * Set template uri with currency placeholders
	 * @param string $templateUri
	 * @return CurrencyExchange\Uri\UriGet
	 */
	public function setTemplateUri($templateUri)
	{
		if (strpos($templateUri, '{%FROMCURRENCY%}') === false || strpos($templateUri, '{%TOCURRENCY%}') === false)
			throw new Exception\InvalidArgumentException('Cannot find "From Currency" or "To Currency" placeholder(s)!');

		$this->_templateUri = $templateUri;
		return $this;
	}
}
