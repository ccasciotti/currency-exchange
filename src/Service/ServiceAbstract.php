<?php

/**
 * CurrencyExchange
 * 
 * A library to retrieve currency exchanges using several web services
 * 
 * @link https://github.com/teknoman/currency-exchange
 * @license http://www.gnu.org/licenses/gpl-3.0.txt
 */

namespace CurrencyExchange\Service;

use CurrencyExchange\HttpClient;
use CurrencyExchange\Uri\UriAbstract;

/**
 * Abstract class for each exchange service
 * 
 * @package CurrencyExchange
 */
abstract class ServiceAbstract
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
		$httpClient->setHttpMethod($this->getUri()->getType()); // Set http method for this exchange method

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
	 * Set a new uri object to handle exchange service
	 * 
	 * @param CurrencyExchange\Uri\UriAbstract $uri A new CurrencyExchange\Uri\UriAbstract object
	 * @return CurrencyExchange\Service\ServiceAbstract
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
	 * @return CurrencyExchange\Service\ServiceAbstract
	 */
	public function setHttpClient(HttpClient $client)
	{
		$this->_httpClient = $client;
		return $this;
	}

    /**
     * Make request via HttpClient object and returns response
     * 
     * @return mixed
     */
    public function getResponseContent()
    {
        return $this->getHttpClient()
                    ->setUri($this->getUri()->getFinalUri())
                    ->makeRequest()
                    ->getResponse()
                    ->getBody();
    }
    
	/**
	 * Returns the exchange rate value 
	 * 
	 * @return float
	 */
	abstract public function getExchangeRate();
}
