<?php

namespace CurrencyExchange\Methods;

use CurrencyExchange\Exception;

/**
 * Base class for each exchange method
 */
abstract class AbstractMethod
{
	/**
	 * @var $_templateUri The template uri that each exchange method must override with the http uri of web service
	 */
	protected $_templateUri = null;
	
	/**
	 * @var $_uri The final uri with the $_fromCurrencyCode and $_toCurrencyCode set
	 */
	protected $_uri = null;
	
	/**
	 * @var $_fromCurrencyCode In the format of 3 character
	 */
	protected $_fromCurrencyCode = null;
	
	/**
	 * @var $_toCurrencyCode In the format of 3 character
	 */
	protected $_toCurrencyCode = null;
	
	/**
	 * @var $_proxy String in the format host:port
	 */
	protected $_proxy = null;
	
	/**
	 * @var $_response Zend\Http\Response
	 */
	protected $_response = null;
	
	public function setFromCurrencyCode($code)
	{
		$this->_fromCurrencyCode = (string) $code;
		return $this;
	}
	
	public function setToCurrencyCode($code)
	{
		$this->_toCurrencyCode = (string) $code;
		return $this;
	}
	
	public function getUri()
	{
		if (!$this->_templateUri)
			throw new Exception\InvalidArgumentException('Template Uri not initialized!');

		if (!$this->_fromCurrencyCode)
			throw new Exception\InvalidArgumentException('"From Currency Code" not initialized!');

		if (!$this->_toCurrencyCode)
			throw new Exception\InvalidArgumentException('"To Currency Code" not initialized!');

		$search = array('{%FROMCURRENCYCODE%}', '{%TOCURRENCYCODE%}');
		$replace = array($this->_fromCurrencyCode, $this->_toCurrencyCode);

		$this->_uri = str_replace($search, $replace, $this->_templateUri);

		return $this->_uri;
	}
	
	public function setProxy($proxy)
	{
		$proxy = (string) $proxy;

		if (!preg_match('/^[a-z0-9\.]+:[0-9]+$/iu', $proxy))
			throw new Exception\InvalidArgumentException('Proxy must be a string according to format host:port');

		$this->_proxy = $proxy;
		return $this;
	}
	
	public function getResponse()
	{
		return $this->_response;
	}
	
	public function downloadExchangeRate()
	{
		$request = new \Zend\Http\Request();
		$request->setUri($this->getUri());
		$request->setMethod('GET');

		$curlOptions = array(
			CURLOPT_HEADER => false,
			CURLOPT_RETURNTRANSFER => true,
		);

		if ($this->_proxy)
			$curlOptions[CURLOPT_PROXY] = $this->_proxy;

		$adapter = new \Zend\Http\Client\Adapter\Curl();
		$adapter->setOptions(array(
			'curloptions' => $curlOptions
		));

		$client = new \Zend\Http\Client();
		$client->setAdapter($adapter);

 		$this->_response = $client->dispatch($request);

		if ($this->_response->getStatusCode() != 200)
			throw new Exception\ResponseException('Error ' . $this->_response->getStatusCode());

		return $this;
	}

	public function getExchangeRate()
	{
		return $this->getResponse()->getBody();
	}

	public function exchange($amount)
	{
		$amount = (float) $amount;

		$exchangeRate = $this->downloadExchangeRate()->getExchangeRate();

		return (float) $exchangeRate * $amount;
	}
}
