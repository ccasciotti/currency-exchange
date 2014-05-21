<?php

namespace CurrencyExchange;

class HttpClient
{
	/**
	 * @var string
	 */
	protected $_uri = null;
	
	/**
	 * @var string
	 */
	protected $_httpMethod = null;
	
	/**
	 * @var array
	 */
	protected $_curlOptions = null;
	
	/**
	 * @var $_proxy String in the format host:port
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
	 * @param string $uri
	 * @return CurrencyExchange\HttpClient
	 */
	public function setUri($uri)
	{
		$this->_uri = (string) $uri;
		return $this;
	}

	/**
	 * @param string $httpMethod Can be GET or POST
	 * @return CurrencyExchange\HttpClient
	 */
	public function setHttpMethod($httpMethod)
	{
		$httpMethod = strtoupper((string) $httpMethod);

		if (!in_array($httpMethod, array('GET', 'POST')))
			throw new Exception\InvalidArgumentException('Http method can be GET or POST, ' . $httpMethod . ' supplied');

		$this->_httpMethod = $httpMethod;
		return $this;
	}

	/**
	 * Sets cURL options
	 * @param array $options
	 * @return CurrencyExchange\HttpClient
	 */
	public function setCurlOptions(array $options)
	{
		$this->_curlOptions = $options;
		return $this;
	}
	
	/**
	 * Set proxy for the http client
	 * @param string $proxy A string that identifies proxy server, in the format 'host:port'
	 * @return CurrencyExchange\HttpClient
	 */
	public function setProxy($proxy)
	{
		$proxy = (string) $proxy;

		if (!preg_match('/^[a-z0-9\.]+:[0-9]+$/iu', $proxy))
			throw new Exception\InvalidArgumentException('Proxy must be a string according to format host:port');

		$this->_proxy = $proxy;
		return $this;
	}
	
	/**
	 * Makes request to download exchange rate
	 * @return CurrencyExchange\HttpClient
	 */
	public function makeRequest()
	{
		$request = new \Zend\Http\Request();
		$request->setUri($this->_uri);
		$request->setMethod($this->_httpMethod);

		if ($this->_proxy)
			$this->_curlOptions[CURLOPT_PROXY] = $this->_proxy;

		$adapter = new \Zend\Http\Client\Adapter\Curl();
		$adapter->setOptions(array(
			'curloptions' => $this->_curlOptions
		));

		$client = new \Zend\Http\Client();
		$client->setAdapter($adapter);

 		$this->_response = $client->dispatch($request);

		if ($this->_response->getStatusCode() != 200)
			throw new Exception\ResponseException('Error ' . $this->_response->getStatusCode());

		return $this;
	}
}
