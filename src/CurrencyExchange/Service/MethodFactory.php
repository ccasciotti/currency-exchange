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

use CurrencyExchange\Methods\MethodAbstract;
use CurrencyExchange\Exception;

/**
 * Factory method class for exchange method objects
 * 
 * @package CurrencyExchange
 * @subpackage Service
 */
class MethodFactory
{
	/**
	 * @var string the default exchange method class
	 */
	protected static $_defaultMethodClass = 'YahooFinance';

	/**
	 * Factory method that instantiates a new AbstractMethod object
	 * 
	 * @param object|string|null $method The exchange method used for getting exchange rate. If null, it will be used the default exchange method class
	 * @throws CurrencyExchange\Exception\InvalidMethodException
	 * @return CurrencyExchange\Methods\AbstractMethod
	 */
	public static function factory($method = null)
	{
		if ($method === null) {
			$method = static::$_defaultMethodClass;
		}

		if (is_string($method)) {
			$method = 'CurrencyExchange\Methods\\' . $method;

			if (!class_exists($method)) {
				throw new Exception\InvalidMethodException('Class ' . $method . ' not found');
			}

			/** @var object */
			$method = new $method();
		}

		if (!is_object($method) || !$method instanceof MethodAbstract) {
			throw new Exception\InvalidMethodException('Exchange method must be an instance of CurrencyExchange\Methods\MethodAbstract, ' . 
				(is_object($method) ? get_class($method) : gettype($method)) . ' given');
		}

		return $method;
	}
}
