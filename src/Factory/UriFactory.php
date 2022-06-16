<?php

declare(strict_types=1);

/**
 * CurrencyExchange
 * 
 * A library to retrieve currency exchanges using several web services
 * 
 * @link https://github.com/ccasciotti/currency-exchange
 * @license http://www.gnu.org/licenses/gpl-3.0.txt
 */

namespace CurrencyExchange\Factory;

use CurrencyExchange\Uri\AbstractUri;
use InvalidArgumentException;
use CurrencyExchange\Http\Request as HttpRequest;
use CurrencyExchange\Uri\GetUri;
use CurrencyExchange\Uri\PostUri;

/**
 * Factory method class for Uri objects
 * 
 * @package CurrencyExchange
 * @final
 */
final class UriFactory
{
	/**
	 * Factory method that instantiates a new UriAbstract object
	 * 
     * @static
	 * @param string $type
	 * @return AbstractUri
     * @throws InvalidArgumentException
	 */
	public static function create(string $type): AbstractUri
	{
		if (!HttpRequest::isHttpMethodSupported($type)) {
			throw new InvalidArgumentException(
                sprintf('Unknown Uri type: %s', $type)
            );
		}

        return match (strtoupper($type)) {
            HttpRequest::HTTP_GET => new GetUri($type),
            HttpRequest::HTTP_POST => new PostUri($type),
        };
	}
}
