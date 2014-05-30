<?php

namespace CurrencyExchange\Uri;

use CurrencyExchange\Exception;

/**
 * Class used to handle uri of each exchange method that uses uri with Http POST mode
 */
class UriPost extends AbstractUri
{
	/**
	 * Returns the final uri with currency codes set
	 * 
	 * @throws CurrencyExchange\Exception\InvalidArgumentException
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

		$this->_uri = $this->_templateUri;
		return $this->_uri;
	}

	/**
	 * Set template uri
	 * 
	 * @param string $templateUri
	 * @return CurrencyExchange\Uri\UriPost
	 */
	public function setTemplateUri($templateUri)
	{
		$this->_templateUri = (string) $templateUri;
		return $this;
	}
}
