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
use Zend\ServiceManager\AbstractFactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

/**
 * Factory method class for exchange method objects
 * 
 * @package CurrencyExchange
 * @subpackage Service
 */
class MethodFactory implements AbstractFactoryInterface
{
	const EXCHANGE_METHOD_NAMESPACE_PREFIX = 'CurrencyExchange\Methods\\';

	/**
     * Determine if we can create a service with name
     *
     * @param ServiceLocatorInterface $serviceLocator
     * @param $name
     * @param $requestedName
     * @return bool
     */
	public function canCreateServiceWithName(ServiceLocatorInterface $serviceLocator, $name, $requestedName)
	{
		return class_exists(static::EXCHANGE_METHOD_NAMESPACE_PREFIX . $requestedName);
	}

	/**
     * Create service with name
     *
     * @param ServiceLocatorInterface $serviceLocator
     * @param $name
     * @param $requestedName
     * @return mixed
     */
	public function createServiceWithName(ServiceLocatorInterface $serviceLocator, $name, $requestedName)
	{
		$class = static::EXCHANGE_METHOD_NAMESPACE_PREFIX . $requestedName;

		/** @var CurrencyExchange\Methods\MethodAbstract */
		$method = new $class($serviceLocator);

		if (!$method instanceof MethodAbstract) {
			throw new Exception\InvalidMethodException('Exchange method must be an instance of CurrencyExchange\Methods\MethodAbstract, ' . 
				get_class($method) . ' given');
		}

		return $method;
	}
}
