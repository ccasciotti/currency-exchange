<?php

/**
 * CurrencyExchange
 * 
 * A library to retrieve currency exchanges using several web services
 * 
 * @link https://github.com/teknoman/currency-exchange
 * @license http://www.gnu.org/licenses/gpl-3.0.txt
 */

namespace CurrencyExchange;

use InvalidArgumentException;
use GuzzleHttp\Client as GuzzleClient;
use GuzzleHttp\Message\ResponseInterface;
use CurrencyExchange\Options;
use CurrencyExchange\Exception\ResponseException;

/**
 * Makes a request to the current Uri
 * 
 * @package CurrencyExchange
 */
class HttpClient
{
	/**
	 * Constant for HTTP method GET
	 */
	const HTTP_GET = 'GET';

	/**
	 * Constant for HTTP method POST
	 */
	const HTTP_POST = 'POST';

    /**
     * Constant for User Agent used in the request
     */
    const USER_AGENT = 'Currency Exchange v2.3';

	/**
	 * @var string The uri to call
	 */
	protected $_uri = null;

	/**
	 * @var string Can be GET or POST
	 */
	protected $_httpMethod = null;

	/**
	 * @var CurrencyExchange\Options An object for handling request's options
	 */
	protected $_requestOptions = null;

	/**
	 * @var array The data to send via Http POST 
	 */
	protected $_postData = array();

	/**
	 * @var GuzzleHttp\Message\ResponseInterface
	 */
	protected $_response = null;

	/**
	 * Constructor set default cURL options
	 */
	public function __construct()
	{
		$this->_requestOptions = new Options();
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
     * @throws CurrencyExchange\Exception\ResponseException
	 * @return CurrencyExchange\HttpClient
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
	 * @return CurrencyExchange\Options
	 */
	public function getRequestOptions()
	{
		return $this->_requestOptions;
	}

	/**
	 * @return array
	 */
	public function getPostData()
	{
		return $this->_postData;
	}

	/**
	 * Checks if Http method is GET
	 * 
	 * @return boolean
	 */
	public function isHttpGet()
	{
		return $this->_httpMethod === static::HTTP_GET;
	}

	/**
	 * Checks if Http method is POST
	 * 
	 * @return boolean
	 */
	public function isHttpPost()
	{
		return $this->_httpMethod === static::HTTP_POST;
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
     * Return current http method
     * 
     * @return string
     */
    public function getHttpMethod()
    {
        return $this->_httpMethod;
    }

    /**
	 * Sets the Http method, only GET or POST are actually supported
	 * 
	 * @param string $httpMethod Can be GET or POST
	 * @throws InvalidArgumentException
	 * @return CurrencyExchange\HttpClient
	 */
	public function setHttpMethod($httpMethod)
	{
		$httpMethod = strtoupper((string) $httpMethod);

		if (!in_array($httpMethod, array(static::HTTP_GET, static::HTTP_POST))) {
			throw new InvalidArgumentException('Http method can be GET or POST, ' . $httpMethod . ' given');
		}

		$this->_httpMethod = $httpMethod;
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
	 * @throws InvalidArgumentException
	 * @return CurrencyExchange\HttpClient
	 */
	public function setProxy($proxy)
	{
		$proxy = (string) $proxy;

		if (!preg_match('/^[a-z0-9\.]+:[0-9]+$/iu', $proxy)) {
			throw new InvalidArgumentException('Proxy must be a string according to format host:port');
		}

		$this->getRequestOptions()->addOption('proxy', $proxy);
		return $this;
	}

	/**
	 * Makes request to the uri currently set
	 * 
	 * @return CurrencyExchange\HttpClient
	 */
	public function makeRequest()
	{
        $requestOptions = $this->getRequestOptions()->getOptions() ?: [];

        $client = new GuzzleClient();
        $request = $client->createRequest($this->getHttpMethod(), $this->getUri(), $requestOptions);
        $request->setHeader('User-Agent', static::USER_AGENT);

        $response = $client->send($request);

		// setting response
		$this->setResponse($response);
		return $this;
	}
}
