<?php

/**
 * CurrencyExchange
 * 
 * A library to retrieve currency exchanges using several web services
 * 
 * @link https://github.com/ccasciotti/currency-exchange
 * @license http://www.gnu.org/licenses/gpl-3.0.txt
 */

namespace CurrencyExchange\Service;

use CurrencyExchange\Exception\ParseException;
use CurrencyExchange\Http\Request as HttpRequest;
use CurrencyExchange\Factory\UriFactory;
use CurrencyExchange\Uri\GetUri;

/**
 * Concrete class to handle webservice from GrandTrunk
 * 
 * @package CurrencyExchange
 */
class GrandTrunk extends AbstractService
{
	public function __construct()
	{
		/** @var GetUri */
		$uri = UriFactory::create(HttpRequest::HTTP_GET);
		$uri->setTemplateUri('https://currencies.apps.grandtrunk.net/getlatest/{%FROMCURRENCY%}/{%TOCURRENCY%}');

		// Istantiates and initializes HttpClient and Uri objects
		parent::__construct($uri);
	}

	/**
	 * Implementation of abstract method getExchangeRate
	 * 
	 * @return float
     * @throws ParseException
	 */
	public function getExchangeRate(): float
	{
		/** @var float */
		$rate = $this->getResponseContent()?->getBody();

		if (!$rate) {
			throw new ParseException('Exchange rate not found');
		}

		return $rate;
	}
}
