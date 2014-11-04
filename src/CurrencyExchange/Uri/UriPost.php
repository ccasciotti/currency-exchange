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

use CurrencyExchange\HttpClient;
use CurrencyExchange\Exception;

/**
 * Class used to handle uri of each exchange method that uses uri with Http POST mode
 * 
 * @package CurrencyExchange
 * @subpackage Uri
 */
class UriPost extends UriAbstract
{
	/**
	 * Contructor invokes setType method
	 */
	public function __construct()
	{
		$this->setType(HttpClient::HTTP_POST);
	}

	/**
	 * Returns the final uri with currency codes set
	 * 
	 * @throws CurrencyExchange\Exception\InvalidArgumentException
	 * @return string
	 */
	public function getFinalUri()
	{
		if (!$this->_templateUri) {
			throw new Exception\InvalidArgumentException('Template Uri not set');
		}

		if (!$this->_fromCurrency) {
			throw new Exception\InvalidArgumentException('"From Currency" not set');
		}

		if (!$this->_toCurrency) {
			throw new Exception\InvalidArgumentException('"To Currency" not set');
		}

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
