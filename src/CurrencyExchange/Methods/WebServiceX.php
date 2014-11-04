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
use Zend\ServiceManager\ServiceLocatorInterface;

/**
 * @package CurrencyExchange
 * @subpackage Methods
 */
class WebServiceX extends MethodAbstract
{
	public function __construct(ServiceLocatorInterface $serviceLocator)
	{
		/** @var CurrencyExchange\Uri\UriGet */
		$uri = $serviceLocator->get('UriGet');
		$uri->setTemplateUri('http://www.webservicex.net/CurrencyConvertor.asmx/ConversionRate?FromCurrency={%FROMCURRENCY%}&ToCurrency={%TOCURRENCY%}');

		// Istantiates and initializes HttpClient and Uri objects
		parent::__construct($uri);
	}

	/**
	 * Implementation of abstract method getExchangeRate
	 * 
	 * @throws CurrencyExchange\Exception\ParseException
	 * @return float
	 */
	public function getExchangeRate()
	{
		// Make request via Http Client
		$this->makeRequest();

		$dom = new DOMDocument();

		if (!$dom->loadXML($this->_httpClient->getResponse()->getBody())) {
			throw new Exception\ParseException('There was an error processing response');
		}

		/** @var DOMNodeList */
		$objects = $dom->getElementsByTagName('double');

		if (!$objects->item(0)) {
			throw new Exception\ParseException('Exchange rate not found');
		}

		return (float) $objects->item(0)->nodeValue;
	}
}
