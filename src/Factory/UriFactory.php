<?php

/**
 * CurrencyExchange
 * 
 * A library to retrieve currency exchanges using several web services
 * 
 * @link https://github.com/teknoman/currency-exchange
 * @license http://www.gnu.org/licenses/gpl-3.0.txt
 */

namespace CurrencyExchange\Factory;

use InvalidArgumentException;
use CurrencyExchange\HttpClient;
use CurrencyExchange\Uri\UriGet;
use CurrencyExchange\Uri\UriPost;

/**
 * Factory method class for Uri objects
 * 
 * @package CurrencyExchange
 */
class UriFactory
{
	/**
	 * Factory method that instantiates a new UriAbstract object
	 * 
     * @static
	 * @param string $type The type of Uri, can be GET or POST
	 * @return CurrencyExchange\Uri\UriAbstract
     * @throws InvalidArgumentException
	 */
	public static function factory($type)
	{
		if (!HttpClient::isHttpMethodSupported($type)) {
			throw new InvalidArgumentException('Unknown Uri type: ' . $type);
		}

		switch (strtoupper((string) $type)) {
			case HttpClient::HTTP_GET :

				/** @var CurrencyExchange\Uri\UriGet */
				$uri = new UriGet($type);
				break;

			case HttpClient::HTTP_POST : 

				/** @var CurrencyExchange\Uri\UriPost */
				$uri = new UriPost($type);
				break;
		}

		return $uri;
	}
}
