<?php

/**
 * CurrencyExchange
 * 
 * A Module for Zend Framework 2 to retrieve current value exchanges using several web services
 * 
 * @link https://github.com/teknoman/currency-exchange
 * @license http://www.gnu.org/licenses/gpl-3.0.txt
 */

namespace CurrencyExchange\Methods;

use DOMDocument;
use CurrencyExchange\Exception;
use CurrencyExchange\HttpClient;
use CurrencyExchange\Service\UriFactory;

/**
 * @package CurrencyExchange
 * @subpackage Methods
 */
class WebServiceX extends MethodAbstract
{
	public function __construct()
	{
		/** @var CurrencyExchange\Uri\UriGet */
		$uri = UriFactory::factory(HttpClient::HTTP_GET);
		$uri->setTemplateUri('http://www.webservicex.net/CurrencyConvertor.asmx/ConversionRate?FromCurrency={%FROMCURRENCY%}&ToCurrency={%TOCURRENCY%}');

		// Istantiates and initializes HttpClient and Uri objects
		parent::__construct($uri);
	}

	/**
	 * Implementation of abstract method getExchangeRate
	 * 
	 * @throws CurrencyExchange\Exception\ResponseException
	 * @return float
	 */
	public function getExchangeRate()
	{
		// Make request via Http Client
		$this->makeRequest();

		$dom = new DOMDocument();
		$dom->loadXML($this->_httpClient->getResponse()->getBody());

		$objects = $dom->getElementsByTagName('double');

		if (!$objects->item(0)) {
			throw new Exception\ResponseException('Exchange rate not found');
		}

		return (float) $objects->item(0)->nodeValue;
	}
}
