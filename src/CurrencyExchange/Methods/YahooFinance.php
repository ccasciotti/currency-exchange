<?php

namespace CurrencyExchange\Methods;

use CurrencyExchange\Exception;
use CurrencyExchange\Uri;

class YahooFinance extends AbstractMethod
{
	public function __construct()
	{
		// Instantiates a new GET Uri object
		$uri = Uri\Factory::create('GET');
		$uri->setTemplateUri('http://download.finance.yahoo.com/d/quotes.csv?s={%FROMCURRENCY%}{%TOCURRENCY%}=X&f=sl1d1t1ba&e=.csv');

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
		$values = explode(',', $this->getResponse()->getBody());

		if (!is_array($values) || !isset($values[1]))
			throw new Exception\ResponseException('Exchange rate not found');

		return (float) $values[1];
	}
}
