<?php

namespace CurrencyExchange\Currency;

use CurrencyExchange\HttpClient;

class Downloader
{
	protected $_httpClient = null;

	public function __construct()
	{
		$this->_httpClient = new HttpClient();
	}

	public function getHttpClient()
	{
		return $this->_httpClient;
	}

	public function syncData()
	{
		$this->_httpClient->setHttpMethod(HttpClient::HTTP_GET);
		$this->_httpClient->setUri('http://data.okfn.org/data/core/currency-codes/r/codes-all.json');
		$this->_httpClient->makeRequest();

		return $this;
	}

	public function getData()
	{
		return $this->_httpClient->getResponse()->getBody();
	}
}
