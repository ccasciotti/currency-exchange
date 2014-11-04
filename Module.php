<?php

/**
 * CurrencyExchange
 * 
 * A Module for Zend Framework 2 to retrieve current value exchanges using several web services
 * 
 * @link https://github.com/teknoman/currency-exchange
 * @license http://www.gnu.org/licenses/gpl-3.0.txt
 */

namespace CurrencyExchange;

/**
 * @package CurrencyExchange
 */
class Module
{
	public function getServiceConfig()
    {
	    return array(
	        'abstract_factories' => array(
	        	'CurrencyExchange\Service\MethodFactory',
	        	'CurrencyExchange\Service\UriFactory',
	        ),
	        'invokables' => array(
				'CurrencyExchange\Exchanger' => 'CurrencyExchange\Exchanger'
			)
	    );
    }

	public function getAutoloaderConfig()
	{
    	return array(
			'Zend\Loader\ClassMapAutoloader' => array(
				__DIR__ . '/autoload_classmap.php',
			),
			'Zend\Loader\StandardAutoloader' => array(
				'namespaces' => array(
					__NAMESPACE__ => __DIR__ . '/src/' . __NAMESPACE__,
				),
			),
		);
	}
	
	public function getConfig()
	{
		return include __DIR__ . '/config/module.config.php';
	}
}