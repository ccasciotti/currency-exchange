<?php

/**
 * CurrencyExchange
 * 
 * A library to retrieve currency exchanges using several web services
 * 
 * @link https://github.com/ccasciotti/currency-exchange
 * @license http://www.gnu.org/licenses/gpl-3.0.txt
 */

namespace CurrencyExchange\Http;

use InvalidArgumentException;
use CurrencyExchange\Exception\ResponseException;
use CurrencyExchange\Http\Request;
use GuzzleHttp\Client as GuzzleClient;
use GuzzleHttp\Message\ResponseInterface;

/**
 * Makes a request to the current Uri
 * 
 * @package CurrencyExchange
 */
class Client
{
	/**
	 * @var string The uri to call
	 */
	protected $_uri = null;

	/**
	 * @var CurrencyExchange\Http\Request
	 */
	protected $_httpRequest = null;

	/**
	 * @var array The data to send via Http POST 
	 */
	protected $_postData = [];

	/**
	 * @var GuzzleHttp\Message\ResponseInterface
	 */
	protected $_response = null;

	/**
	 * Constructor set Options object
	 */
	public function __construct()
	{
		$this->_httpRequest = new Request();
	}

	/**
	 * @return GuzzleHttp\Message\ResponseInterface
	 */
	public function getResponse()
	{
		return $this->_response;
	}

	/**
	 * Set Http response in case of successful request
	 * 
	 * @param GuzzleHttp\Message\ResponseInterface $response
	 * @return CurrencyExchange\HttpClient
     * @throws CurrencyExchange\Exception\ResponseException
	 */
	public function setResponse(ResponseInterface $response)
	{
        if ($response->getStatusCode() != 200) {
			throw new ResponseException('Unsuccessful HTTP request: ' . $response->getStatusCode() . ' on ' . $this->getUri());
		}

        $this->_response = $response;
		return $this;
	}

    /**
	 * @return CurrencyExchange\Http\Request
	 */
	public function getHttpRequest()
	{
		return $this->_httpRequest;
	}

	/**
	 * @return array
	 */
	public function getPostData()
	{
		return $this->_postData;
	}

    /**
     * Return current uri
     * 
     * @return string
     */
    public function getUri()
    {
        return $this->_uri;
    }

    /**
	 * @param string $uri
	 * @return CurrencyExchange\HttpClient
	 */
	public function setUri($uri)
	{
		$this->_uri = (string) $uri;
		return $this;
	}

	/**
	 * Set data to be sent via Http POST
	 * 
	 * @param array $postData
	 * @return CurrencyExchange\HttpClient
	 */
	public function setPostData(array $postData)
	{
		$this->_postData = $postData;
		return $this;
	}

	/**
	 * Set proxy for the http client
	 * 
	 * @param string $proxy A string that identifies proxy server, in the format 'host:port'
	 * @return CurrencyExchange\HttpClient
     * @throws InvalidArgumentException
	 */
	public function setProxy($proxy)
	{
		if (!is_string($proxy)) {
            throw new InvalidArgumentException('Proxy must be a string, ' . gettype($proxy) . ' given.');
        }

		if (!preg_match('/^[a-z0-9\.]+:[0-9]+$/iu', $proxy)) {
			throw new InvalidArgumentException('Proxy must be a string according to format host:port');
		}

		$this->getHttpRequest()->getOptions()->add('proxy', $proxy);
		return $this;
	}

	/**
	 * Makes request to the uri currently set
	 * 
	 * @return CurrencyExchange\HttpClient
	 */
	public function makeRequest()
	{
        $requestOptions = $this->getHttpRequest()->getOptions()->getAll() ?: [];

        $client = new GuzzleClient();
        $client->setDefaultOption('headers', $this->getHttpRequest()->getHeaders()->getAll());
        $request = $client->createRequest($this->getHttpRequest()->getHttpMethod(), $this->getUri(), $requestOptions);

		// setting response
		$this->setResponse($client->send($request));
		return $this;
	}
}
