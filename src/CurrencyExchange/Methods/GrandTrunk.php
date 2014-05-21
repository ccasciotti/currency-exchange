<?php

namespace CurrencyExchange\Methods;

use CurrencyExchange\Exception;

class GrandTrunk extends AbstractMethod
{
	public function __construct()
	{
		// Initialize Uri object and HttpClient object
		parent::__construct();

		// Set template uri for this exchange method
		$this->getUri()->setTemplateUri('http://currencies.apps.grandtrunk.net/getlatest/{%FROMCURRENCY%}/{%TOCURRENCY%}');

		// Set http method for this exchange method
		$this->getHttpClient()->setHttpMethod('GET');
	}

	public function getExchangeRate()
	{
		return (float) $this->getResponse()->getBody();
	}
}
