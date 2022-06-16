<?php

/**
 * CurrencyExchange
 * 
 * A library to retrieve currency exchanges using several web services
 * 
 * @link https://github.com/ccasciotti/currency-exchange
 * @license http://www.gnu.org/licenses/gpl-3.0.txt
 */

namespace CurrencyExchange\Factory;

use CurrencyExchange\Service\GrandTrunk;
use CurrencyExchange\Service\AbstractService;
use RuntimeException;

/**
 * Factory method class for exchange services
 * 
 * @package CurrencyExchange
 * @final
 */
final class ServiceFactory
{
	/**
	 * @var string the default exchange service class
     * @static
	 */
	public static string $defaultExchangeService = GrandTrunk::class;

	/**
	 * Factory method that instantiates a new ServiceAbstract object
	 * 
     * @static
	 * @param AbstractService|string|null $service The exchange service used for getting exchange rate. If null, it will be used the default exchange service
	 * @return AbstractService
     * @throws RuntimeException
	 */
	public static function create(AbstractService|string $service = null): AbstractService
	{
		if ($service === null) {
			$service = self::$defaultExchangeService;
		}

		if (is_string($service)) {
			if (!class_exists($service)) {
				throw new RuntimeException(
                    sprintf('Class %s not found', $service)
                );
			}

			/** @var AbstractService $service */
			$service = new $service();
		}

		return $service;
	}
}
