<?php

/**
 * CurrencyExchange
 * 
 * A library to retrieve currency exchanges using several web services
 * 
 * @link https://github.com/teknoman/currency-exchange
 * @license http://www.gnu.org/licenses/gpl-3.0.txt
 */

namespace CurrencyExchange\Currency;

use CurrencyExchange\HttpClient;
use Zend\Json\Json;
use RuntimeException;

/**
 * Class that retrieves currency's informations
 * 
 * @package CurrencyExchange
 */
class Downloader
{
	/** 
	 * @var CurrencyExchange\HttpClient
	 */
	protected $_httpClient = null;

	/**
	 * @var boolean
	 */
	protected $_filterData = null;

	/** 
	 * @var string The default currency database uri
	 */
	protected $_currencyDatabaseUri = 'http://data.okfn.org/data/core/currency-codes/r/codes-all.json';

	/**
	 * Constructor instantiates CurrencyExchange\HttpClient object and sets filterData flag
	 * 
	 * @param boolean $filterData
	 */
	public function __construct($filterData = true)
	{
		$this->_httpClient = new HttpClient();
		$this->setFilterData($filterData);
	}

	/**
	 * Returns currency CurrencyExchange\HttpClient instance
	 * 
	 * @return CurrencyExchange\HttpClient
	 */
	public function getHttpClient()
	{
		return $this->_httpClient;
	}

	/**
	 * Returns filterData flag
	 * 
	 * @return boolean
	 */
	public function getFilterData()
	{
		return $this->_filterData;
	}

	/**
	 * Sets filterData flag
	 * 
	 * @param boolean $filterData
	 * @return CurrencyExchange\Currency\Downloader
	 */
	public function setFilterData($filterData = true)
	{
		$this->_filterData = (bool) $filterData;
		return $this;
	}

	/**
	 * Returns Currency Database Uri
	 * 
	 * @return string
	 */
	public function getCurrencyDatabaseUri()
	{
		return $this->_currencyDatabaseUri;
	}

	/**
	 * Sets new Currency Database Uri
	 * 
	 * @param string $uri
	 * @throws RuntimeException
	 * @return CurrencyExchange\Currency\Downloader
	 */
	public function setCurrencyDatabaseUri($uri)
	{
		$uri = (string) $uri;

		if (filter_var($uri, FILTER_VALIDATE_URL) === false) {
			throw new RuntimeException('Supplied Currency Database Uri is not a valid Uri.');
		}

		$this->_currencyDatabaseUri = $uri;
		return $this;
	}

	/**
	 * Make the request and returns its response content
	 * 
	 * @return string
	 */
	public function makeRequest()
	{
		$this->_httpClient->setHttpMethod(HttpClient::HTTP_GET);
		$this->_httpClient->setUri($this->getCurrencyDatabaseUri());
		$this->_httpClient->makeRequest();

		$data = $this->_httpClient->getResponse()->getBody();
		if ($this->_filterData === true) {
			/** @var string */
			$data = $this->filterData($data);
		}

		return $data;
	}

	/**
	 * Filter currency's data with only active currencies
	 * 
	 * @param string $data
	 * @return string
	 */
	public function filterData($data)
	{
		/** @var array */
		$data = Json::decode($data);

		$filteredData = array_filter($data, function($element) {
			return !isset($element->WithdrawalDate);
		});

		return Json::encode($filteredData);
	}
}
