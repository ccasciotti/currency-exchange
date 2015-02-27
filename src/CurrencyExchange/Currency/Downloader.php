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
     * @var string 
     */
    protected $_currencyData = null;

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
	 * Set to filter data or not
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
     * Return currency data
     * 
     * @return mixed
     */
    public function getCurrencyData()
    {
        return $this->_currencyData;
    }

    /**
     * Set currency data
     * 
     * @param mixed $data
     * @return \CurrencyExchange\Currency\Downloader
     */
    public function setCurrencyData($data)
    {
        if ($this->getFilterData()) {
			/** @var string */
			$data = $this->_filterData($data);
		}

        $this->_currencyData = $data;
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
	 * Make the request and save the content
	 * 
	 * @return CurrencyExchange\Currency\Downloader
	 */
	public function makeRequest()
	{
        $data = $this->getHttpClient()
                     ->setHttpMethod(HttpClient::HTTP_GET)
                     ->setUri($this->getCurrencyDatabaseUri())
                     ->makeRequest()
                     ->getResponse()
                     ->getBody();

        $this->setCurrencyData($data);
        return $this;
	}

	/**
	 * Filter currency's data with only active currencies
	 * 
	 * @param string $data
	 * @return string
	 */
	protected function _filterData($data)
	{
        /** @var array */
        $data = Json::decode($data);

		$filteredData = array_filter($data, function($element) {
			return !isset($element->WithdrawalDate);
		});

        // Note: use array_values to avoid malformed encoding if first element is missing
		return Json::encode(array_values($filteredData));
	}
}
