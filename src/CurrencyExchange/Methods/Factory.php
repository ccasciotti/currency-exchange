<?php

namespace CurrencyExchange\Methods;

use CurrencyExchange\Exception;

/**
 * Factory method class for exchange method objects
 */
class Factory
{
	/**
	 * @var string the default exchange method class
	 */
	protected static $_defaultMethodClass = 'CurrencyExchange\Methods\GrandTrunk';

	/**
	 * Factory method to instantiates a new AbstractMethod object
	 * 
	 * @param object|string|null $method The exchange method used for getting exchange rate. If null, it will be used the default exchange method class
	 * @throws CurrencyExchange\Exception\InvalidMethodException
	 * @return CurrencyExchange\Methods\AbstractMethod
	 */
	public static function create($method = null)
	{
		if ($method === null)
			$method = static::$_defaultMethodClass;

		if (is_string($method))
		{
			if (!class_exists($method))
				throw new Exception\InvalidMethodException('Exchange method not found');

			$method = new $method();
		}

		if (!($method instanceof AbstractMethod))
			throw new Exception\InvalidMethodException('Invalid exchange method supplied');

		return $method;
	}
}
