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
use CurrencyExchange\Http\Request as HttpRequest;
use CurrencyExchange\Factory\UriFactory;

/**
 * Concrete class to handle webservice from GrandTrunk
 * 
 * @package CurrencyExchange
 */
class GrandTrunk extends ServiceAbstract
{
	public function __construct()
	{
		/** @var CurrencyExchange\Uri\UriGet */
		$uri = UriFactory::factory(HttpRequest::HTTP_GET);
		$uri->setTemplateUri('http://currencies.apps.grandtrunk.net/getlatest/{%FROMCURRENCY%}/{%TOCURRENCY%}');

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
		/** @var float */
		$rate = $this->getResponseContent()->getBody();

		if (!$rate) {
			throw new ParseException('Exchange rate not found');
		}

		return $rate;
	}
}
