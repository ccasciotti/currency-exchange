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

use CurrencyExchange\Exception;
use CurrencyExchange\Uri\AbstractUri;
use CurrencyExchange\Service\UriFactory;

/**
 * @package CurrencyExchange
 * @subpackage Methods
 */
class GrandTrunk extends AbstractMethod
{
	public function __construct()
	{
		/** @var CurrencyExchange\Uri\UriGet */
		$uri = UriFactory::factory(AbstractUri::HTTP_GET);
		$uri->setTemplateUri('http://currencies.apps.grandtrunk.net/getlatest/{%FROMCURRENCY%}/{%TOCURRENCY%}');

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
		parent::getExchangeRate();

		/** @var float */
		$rate = (float) $this->_httpClient->getResponse()->getBody();

		if (!$rate) {
			throw new Exception\ResponseException('Exchange rate not found');
		}

		return $rate;
	}
}
