<?php

/**
 * CurrencyExchange
 * 
 * A Module for Zend Framework 2 to retrieve current value exchanges using several web services
 * 
 * @link https://github.com/teknoman/currency-exchange
 * @license http://www.gnu.org/licenses/gpl-3.0.txt
 */

namespace CurrencyExchange\Methods;

use CurrencyExchange\HttpClient;
use CurrencyExchange\Uri\UriAbstract;
use CurrencyExchange\Exception;

/**
 * Base class for each exchange method
 * 
 * @package CurrencyExchange
 * @subpackage Methods
 */
abstract class MethodAbstract
{
	/**
	 * @var CurrencyExchange\Uri\UriAbstract
	 */
	protected $_uri = null;

	/**
	 * @var CurrencyExchange\HttpClient 
	 */
	protected $_httpClient = null;

	/**
	 * Instantiates a new CurrencyExchange\HttpClient object and initializes it with http type of uri
	 * 
	 * @param CurrencyExchange\Uri\UriAbstract $uri
	 */
	public function __construct(UriAbstract $uri)
	{
		$this->setUri($uri);

		/** @var CurrencyExchange\HttpClient */
		$httpClient = new HttpClient();
		$httpClient->setHttpMethod($this->_uri->getType()); // Set http method for this exchange method

		$this->setHttpClient($httpClient);
	}

	/**
	 * Returns uri object
	 * 
	 * @return CurrencyExchange\UriAbstract
	 */
	public function getUri()
	{
		return $this->_uri;
	}

	/**
	 * Returns http client object
	 * 
	 * @return CurrencyExchange\HttpClient
	 */
	public function getHttpClient()
	{
		return $this->_httpClient;
	}

	/**
	 * Set a new uri object to handle exchange method web service
	 * 
	 * @param CurrencyExchange\Uri\UriAbstract $uri A new CurrencyExchange\Uri\UriAbstract object
	 * @return CurrencyExchange\Methods\MethodAbstract
	 */
	public function setUri(UriAbstract $uri)
	{
		$this->_uri = $uri;
		return $this;
	}

	/**
	 * Set a new http client object to handle exchange method's request and response
	 * 
	 * @param CurrencyExchange\HttpClient $client A new CurrencyExchange\HttpClient object
	 * @return CurrencyExchange\Methods\MethodAbstract
	 */
	public function setHttpClient(HttpClient $client)
	{
		$this->_httpClient = $client;
		return $this;
	}

	/**
	 * Makes request to the final uri sets in Uri object
	 * 
	 * @return CurrencyExchange\Methods\MethodAbstract
	 */
	public function makeRequest()
	{
		$this->_httpClient
			->setUri($this->_uri->getFinalUri())
			->makeRequest();

		return $this;
	}

	/**
	 * Returns the exchange rate value, all Currency Methods must implement this method 
	 * 
	 * @return float
	 */
	abstract public function getExchangeRate();
}
