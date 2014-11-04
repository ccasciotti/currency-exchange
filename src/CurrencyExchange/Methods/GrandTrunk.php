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
use Zend\ServiceManager\ServiceLocatorInterface;

/**
 * @package CurrencyExchange
 * @subpackage Methods
 */
class GrandTrunk extends MethodAbstract
{
	public function __construct(ServiceLocatorInterface $serviceLocator)
	{
		/** @var CurrencyExchange\Uri\UriGet */
		$uri = $serviceLocator->get('UriGet');
		$uri->setTemplateUri('http://currencies.apps.grandtrunk.net/getlatest/{%FROMCURRENCY%}/{%TOCURRENCY%}');

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

		/** @var float */
		$rate = (float) $this->_httpClient->getResponse()->getBody();

		if (!$rate) {
			throw new Exception\ParseException('Exchange rate not found');
		}

		return $rate;
	}
}
