<?php

/**
 * CurrencyExchange
 * 
 * A library to retrieve currency exchanges using several web services
 * 
 * @link https://github.com/teknoman/currency-exchange
 * @license http://www.gnu.org/licenses/gpl-3.0.txt
 */

namespace CurrencyExchange\Service;

use CurrencyExchange\Exception\ParseException;
use CurrencyExchange\HttpClient;
use CurrencyExchange\Factory\UriFactory;

/**
 * Concrete class to handle webservice from WebServiceX
 * 
 * @package CurrencyExchange
 */
class WebServiceX extends ServiceAbstract
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
	 * @return float
     * @throws CurrencyExchange\Exception\ParseException
	 */
	public function getExchangeRate()
	{
        $object = $this->getResponseContent()->xml();

        if (!$object[0] || (float) $object[0] == 0) {
			throw new ParseException('Exchange rate not found');
		}

		return (float) $object[0];
	}
}
