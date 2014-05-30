<?php

namespace CurrencyExchange\Methods;

use CurrencyExchange\Exception;
use CurrencyExchange\Uri;

class GoogleExchangeRate extends AbstractMethod
{
	public function __construct()
	{
		// Instantiates a new GET Uri object
		$uri = Uri\Factory::create('GET');
		$uri->setTemplateUri('http://rate-exchange.appspot.com/currency?from={%FROMCURRENCY%}&to={%TOCURRENCY%}');

		// Set uri object
		$this->setUri($uri);

		// Istantiates and initializes HttpClient object
		parent::__construct();
	}

	/**
	 * Implementation of abstract method getExchangeRate
	 * 
	 * @throws CurrencyExchange\Exception\ResponseException
	 * @return float
	 */
	public function getExchangeRate()
	{
		$object = \Zend\Json\Json::decode($this->getResponse()->getBody());

		if (!isset($object->rate))
			throw new Exception\ResponseException('Exchange rate not found');

		return (float) $object->rate;
	}
}
