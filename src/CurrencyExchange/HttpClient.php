<?php

/**
 * CurrencyExchange
 * 
 * A Module for Zend Framework 2 to retrieve current value exchanges using several web services
 * 
 * @link https://github.com/teknoman/currency-exchange
 * @license http://www.gnu.org/licenses/gpl-3.0.txt
 */

namespace CurrencyExchange;

use Zend\Http\Request as HttpRequest;
use Zend\Http\Client\Adapter\Curl as CurlAdapter;
use Zend\Http\Client as ZendHttpClient;

/**
 * Class that makes request to the Uri currently set
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
	 * @var string The uri to call
	 */
	protected $_uri = null;

	/**
	 * @var string Can be GET or POST
	 */
	protected $_httpMethod = null;

	/**
	 * @var array An array with options for cURL
	 */
	protected $_curlOptions = null;

	/**
	 * @var array The data to send via Http POST 
	 */
	protected $_postData = array();

	/**
	 * @var string Proxy string according to the format host:port (Eg. proxy.example.host:8080)
	 */
	protected $_proxy = null;

	/**
	 * @var Zend\Http\Response
	 */
	protected $_response = null;

	/**
	 * Constructor set default cURL options
	 */
	public function __construct()
	{
		$this->setCurlOptions(array(
			CURLOPT_HEADER => false,
			CURLOPT_RETURNTRANSFER => true,
		));
	}

	/**
	 * @return Zend\Http\Response
	 */
	public function getResponse()
	{
		return $this->_response;
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
	 * @param string $uri
	 * @return CurrencyExchange\HttpClient
	 */
	public function setUri($uri)
	{
		$this->_uri = (string) $uri;
		return $this;
	}

	/**
	 * Sets the Http method, only GET or POST are actually supported
	 * 
	 * @param string $httpMethod Can be GET or POST
	 * @throws CurrencyExchange\Exception\InvalidArgumentException
	 * @return CurrencyExchange\HttpClient
	 */
	public function setHttpMethod($httpMethod)
	{
		$httpMethod = strtoupper((string) $httpMethod);

		if (!in_array($httpMethod, array(static::HTTP_GET, static::HTTP_POST))) {
			throw new Exception\InvalidArgumentException('Http method can be GET or POST, ' . $httpMethod . ' given');
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
	 * Add cURL option
	 * 
	 * @param int $curlOpt
	 * @param mixed $value
	 * @param boolean $override if true, the existent value of $curlOpt is overridden
	 * @return CurrencyExchange\HttpClient
	 */
	public function addCurlOption($curlOpt, $value, $override = false)
	{
		$override = (bool) $override;

		if ($override || !array_key_exists($curlOpt, $this->_curlOptions)) {
			$this->_curlOptions[$curlOpt] = $value;
		}

		return $this;
	}

	/**
	 * Sets cURL options
	 * 
	 * @param array $options
	 * @return CurrencyExchange\HttpClient
	 */
	public function setCurlOptions(array $options)
	{
		$this->_curlOptions = $options;
		return $this;
	}

	/**
	 * Resets cURL options
	 * 
	 * @return CurrencyExchange\HttpClient
	 */
	public function resetCurlOptions()
	{
		$this->_curlOptions = array();
		return $this;
	}

	/**
	 * Set proxy for the http client
	 * 
	 * @param string $proxy A string that identifies proxy server, in the format 'host:port'
	 * @throws CurrencyExchange\Exception\InvalidArgumentException
	 * @return CurrencyExchange\HttpClient
	 */
	public function setProxy($proxy)
	{
		$proxy = (string) $proxy;

		if (!preg_match('/^[a-z0-9\.]+:[0-9]+$/iu', $proxy)) {
			throw new Exception\InvalidArgumentException('Proxy must be a string according to format host:port');
		}

		$this->_proxy = $proxy;
		return $this;
	}

	/**
	 * Makes request to download exchange rate
	 * 
	 * @throws CurrencyExchange\Exception\ResponseException
	 * @return CurrencyExchange\HttpClient
	 */
	public function makeRequest()
	{
		/** @var Zend\Http\Request */
		$request = new HttpRequest();
		$request->setUri($this->_uri);
		$request->setMethod($this->_httpMethod);

		if ($this->_proxy) {
			$this->addCurlOption(CURLOPT_PROXY, $this->_proxy);
		}

		if ($this->isHttpPost()) {
			$this->addCurlOption(CURLOPT_POST, true);
			$this->addCurlOption(CURLOPT_POSTFIELDS, $this->_postData);
		}

		/** @var Zend\Http\Client\Adapter\Curl */
		$adapter = new CurlAdapter();
		$adapter->setOptions(array(
			'curloptions' => $this->_curlOptions
		));

		/** @var Zend\Http\Client */
		$client = new ZendHttpClient();
		$client->setAdapter($adapter);

		/** @var Zend\Http\Response */
 		$this->_response = $client->dispatch($request);

		if ($this->_response->getStatusCode() != 200) {
			throw new Exception\ResponseException('HTTP Error ' . $this->_response->getStatusCode());
		}

		return $this;
	}
}
