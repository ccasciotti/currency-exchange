<?php

namespace CurrencyExchange\Methods;

use CurrencyExchange\Exception;
use CurrencyExchange\Uri;

class GrandTrunk extends AbstractMethod
{
	public function __construct()
	{
		// Instantiates a new GET Uri object
		$uri = Uri\Factory::create('GET');
		$uri->setTemplateUri('http://currencies.apps.grandtrunk.net/getlatest/{%FROMCURRENCY%}/{%TOCURRENCY%}');

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
		$rate = (float) $this->getResponse()->getBody();

		if (!$rate)
			throw new Exception\ResponseException('Exchange rate not found');

		return $rate;
	}
}
