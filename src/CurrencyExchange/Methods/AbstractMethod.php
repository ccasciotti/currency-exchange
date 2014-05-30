<?php

namespace CurrencyExchange\Methods;

use CurrencyExchange\Exception;

/**
 * Base class for each exchange method
 */
abstract class AbstractMethod
{
	/**
	 * @var CurrencyExchange\Uri\AbstractUri The Uri object used to set currency codes and template uri for method
	 */
	protected $_uri = null;

	/**
	 * @var CurrencyExchange\HttpClient 
	 */
	protected $_httpClient = null;

	/**
	 * @var Zend\Http\Response
	 */
	protected $_response = null;

	/**
	 * Constructor set a new CurrencyExchange\HttpClient object and initializes it with http type of uri
	 * 
	 * @return void
	 */
	public function __construct()
	{
		$httpClient = new \CurrencyExchange\HttpClient();
		$httpClient->setHttpMethod($this->getUri()->getType()); // Set http method for this exchange method

		$this->setHttpClient($httpClient);
	}

	/**
	 * Returns uri object
	 * 
	 * @return CurrencyExchange\AbstractUri
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
	 * @param CurrencyExchange\Uri\AbstractUri $uri A new CurrencyExchange\Uri\AbstractUri object
	 * @return CurrencyExchange\Methods\AbstractMethod
	 */
	public function setUri(\CurrencyExchange\Uri\AbstractUri $uri)
	{
		$this->_uri = $uri;
		return $this;
	}

	/**
	 * Set a new http client object to handle exchange method's request and response
	 * 
	 * @param CurrencyExchange\HttpClient $client A new CurrencyExchange\HttpClient object
	 * @return CurrencyExchange\Methods\AbstractMethod
	 */
	public function setHttpClient(\CurrencyExchange\HttpClient $client)
	{
		$this->_httpClient = $client;
		return $this;
	}

	/**
	 * Set response from CurrencyExchange\HttpClient object and return it
	 * 
	 * @return Zend\Http\Response
	 */
	public function getResponse()
	{
		if (!$this->_response)
		{
			$this->getHttpClient()->setUri($this->getUri()->getFinalUri());
			$this->_response = $this->getHttpClient()->makeRequest()->getResponse();
		}

		return $this->_response;
	}

	/**
	 * Each exchange method must implement this method
	 */
	abstract public function getExchangeRate();
}
