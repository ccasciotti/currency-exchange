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

use RuntimeException;
use CurrencyExchange\Service\ServiceAbstract;

/**
 * Factory method class for exchange services
 * 
 * @package CurrencyExchange
 */
class ServiceFactory
{
	/**
	 * @var string the default exchange service class
	 */
	protected static $_defaultExchangeService = 'YahooFinance';

	/**
	 * Factory method that instantiates a new ServiceAbstract object
	 * 
	 * @param object|string|null $service The exchange service used for getting exchange rate. If null, it will be used the default exchange service
	 * @throws RuntimeException
	 * @return CurrencyExchange\Service\ServiceAbstract
	 */
	public static function factory($service = null)
	{
		if ($service === null) {
			$service = static::$_defaultExchangeService;
		}

		if (is_string($service)) {
			$service = 'CurrencyExchange\Service\\' . $service;

			if (!class_exists($service)) {
				throw new RuntimeException('Class ' . $service . ' not found');
			}

			/** @var object */
			$service = new $service();
		}

		if (!is_object($service) || !$service instanceof ServiceAbstract) {
			throw new RuntimeException('Exchange method must be an instance of CurrencyExchange\Service\ServiceAbstract, ' . 
				(is_object($service) ? get_class($service) : gettype($service)) . ' given');
		}

		return $service;
	}
}
