<?php

/**
 * CurrencyExchange
 * 
 * A Module for Zend Framework 2 to retrieve current value exchanges using several web services
 * 
 * @link https://github.com/teknoman/currency-exchange
 * @license http://www.gnu.org/licenses/gpl-3.0.txt
 */

namespace CurrencyExchange\Service;

use CurrencyExchange\HttpClient;
use CurrencyExchange\Uri;
use CurrencyExchange\Exception;

/**
 * Factory method class for Uri objects
 * 
 * @package CurrencyExchange
 * @subpackage Service
 */
class UriFactory
{
	/**
	 * Factory method that instantiates a new UriAbstract object
	 * 
	 * @param string $type The type of Uri, can be GET or POST
	 * @throws CurrencyExchange\Exception\InvalidArgumentException
	 * @return CurrencyExchange\Uri\UriAbstract
	 */
	public static function factory($type)
	{
		/** @var string */
		$type = strtoupper((string) $type);

		if (!in_array($type, array(HttpClient::HTTP_GET, HttpClient::HTTP_POST))) {
			throw new Exception\InvalidArgumentException('Unknown Uri type: ' . $type);
		}

		switch ($type) {
			case HttpClient::HTTP_GET :

				/** @var CurrencyExchange\Uri\UriGet */
				$uri = new Uri\UriGet($type);
				break;

			case HttpClient::HTTP_POST : 

				/** @var CurrencyExchange\Uri\UriPost */
				$uri = new Uri\UriPost($type);
				break;
		}

		return $uri;
	}
}
