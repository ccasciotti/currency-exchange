<?php

namespace CurrencyExchange\Methods;

use CurrencyExchange\Exception;

class GrandTrunk extends AbstractMethod
{
	public function __construct()
	{
		// Initialize HttpClient object
		parent::__construct();

		// Instantiate a new Uri object
		$this->setUri(new \CurrencyExchange\Uri\UriGet());

		// Set template uri for this exchange method
		$this->getUri()->setTemplateUri('http://currencies.apps.grandtrunk.net/getlatest/{%FROMCURRENCY%}/{%TOCURRENCY%}');

		// Set http method for this exchange method
		$this->getHttpClient()->setHttpMethod('GET');
	}

	public function getExchangeRate()
	{
		$rate = (float) $this->getResponse()->getBody();

		if (!$rate)
			throw new Exception\ResponseException('Exchange rate not found');

		return $rate;
	}
}
