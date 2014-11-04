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
 * Class used to handle uri of each exchange method that uses uri with Http GET mode
 * 
 * @package CurrencyExchange
 * @subpackage Uri
 */
class UriGet extends UriAbstract
{
	/**
	 * Contructor invokes setType method
	 */
	public function __construct()
	{
		$this->setType(HttpClient::HTTP_GET);
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

		$search = array('{%FROMCURRENCY%}', '{%TOCURRENCY%}');
		$replace = array($this->_fromCurrency->getCode(), $this->_toCurrency->getCode());

		$this->_uri = str_replace($search, $replace, $this->_templateUri);
		return $this->_uri;
	}

	/**
	 * Set template uri with currency placeholders
	 * 
	 * @param string $templateUri
	 * @throws CurrencyExchange\Exception\InvalidArgumentException
	 * @return CurrencyExchange\Uri\UriGet
	 */
	public function setTemplateUri($templateUri)
	{
		$templateUri = (string) $templateUri;

		if (strpos($templateUri, '{%FROMCURRENCY%}') === false) {
			throw new Exception\InvalidArgumentException('Cannot find "From Currency" placeholder');
		}

		if (strpos($templateUri, '{%TOCURRENCY%}') === false) {
			throw new Exception\InvalidArgumentException('Cannot find "To Currency" placeholder');
		}

		$this->_templateUri = $templateUri;
		return $this;
	}
}
