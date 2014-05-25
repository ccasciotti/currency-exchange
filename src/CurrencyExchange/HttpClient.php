<?php

namespace CurrencyExchange;

class HttpClient
{
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
	 * @return boolean
	 */
	public function isHttpGet()
	{
		return $this->_httpMethod === 'GET';
	}

	/**
	 * Checks if Http method is POST
	 * @return boolean
	 */
	public function isHttpPost()
	{
		return $this->_httpMethod === 'POST';
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
			throw new Exception\InvalidArgumentException('Http method can be GET or POST, ' . $httpMethod . ' given');

		$this->_httpMethod = $httpMethod;
		return $this;
	}

	/**
	 * Set data to be sent via Http POST
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
	 * @param int $curlOpt
	 * @param mixed $value
	 * @param boolean $override if true, the existent value of $curlOpt is overridden
	 * @return CurrencyExchange\HttpClient
	 */
	public function addCurlOption($curlOpt, $value, $override = false)
	{
		$override = (bool) $override;

		if ($override || !array_key_exists($curlOpt, $this->_curlOptions))
			$this->_curlOptions[$curlOpt] = $value;

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
	 * Resets cURL options
	 * @return CurrencyExchange\HttpClient
	 */
	public function resetCurlOptions()
	{
		$this->_curlOptions = array();
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
			$this->addCurlOption(CURLOPT_PROXY, $this->_proxy);

		if ($this->isHttpPost())
		{
			$this->addCurlOption(CURLOPT_POST, true);
			$this->addCurlOption(CURLOPT_POSTFIELDS, $this->getPostData());
		}

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
