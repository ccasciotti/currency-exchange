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

use CurrencyExchange\Uri\UriAbstract;
use CurrencyExchange\Exception;
use Zend\ServiceManager\AbstractFactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

/**
 * Factory method class for Uri objects
 * 
 * @package CurrencyExchange
 * @subpackage Service
 */
class UriFactory implements AbstractFactoryInterface
{
	const URI_NAMESPACE_PREFIX = 'CurrencyExchange\Uri\\';

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
		return class_exists(static::URI_NAMESPACE_PREFIX . $requestedName);
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
		$class = static::URI_NAMESPACE_PREFIX . $requestedName;

		/** @var CurrencyExchange\Uri\UriAbstract */
		$uri = new $class;

		if (!$uri instanceof UriAbstract) {
			throw new Exception\InvalidArgumentException('Uri must be an instance of CurrencyExchange\Uri\UriAbstract, ' . 
				get_class($uri) . ' given');
		}

		return $uri;
	}
}
