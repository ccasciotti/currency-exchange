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
use Zend\Json\Json;

/**
 * @package CurrencyExchange
 */
class GoogleExchangeRate extends ServiceAbstract
{
	public function __construct()
	{
		/** @var CurrencyExchange\Uri\UriGet */
		$uri = UriFactory::factory(HttpClient::HTTP_GET);
		$uri->setTemplateUri('http://rate-exchange.appspot.com/currency?from={%FROMCURRENCY%}&to={%TOCURRENCY%}');

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
		/** @var object */
		$response = Json::decode($this->getResponseContent());

		if (!isset($response->rate) || !$response->rate) {
			throw new ParseException('Exchange rate not found');
		}

		return (float) $response->rate;
	}
}
