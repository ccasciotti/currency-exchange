<?php

namespace CurrencyExchange\Uri;

use CurrencyExchange\Exception;

/**
 * Factory method class for Uri objects
 */
class Factory
{
	/**
	 * Factory method to instantiates a new AbstractUri object
	 * 
	 * @param string $type The type of Uri, can be GET or POST
	 * @throws CurrencyExchange\Exception\InvalidArgumentException
	 * @return CurrencyExchange\Uri\AbstractUri
	 */
	public static function create($type)
	{
		$type = strtoupper((string) $type);

		if (!in_array($type, array('GET', 'POST')))
			throw new Exception\InvalidArgumentException('Uri type must be GET or POST, ' . $type . ' given');

		switch ($type)
		{
			case 'GET' :

				$uri = new UriGet($type);
				break;

			case 'POST' : 

				$uri = new UriPost($type);
				break;
		}

		return $uri;
	}
}
