<?php

namespace CurrencyExchange\Methods;

use CurrencyExchange\Exception;

class YahooFinance extends AbstractMethod
{
	public function __construct()
	{
		// Initialize HttpClient object
		parent::__construct();

		// Instantiate a new Uri object
		$this->setUri(new \CurrencyExchange\Uri\UriGet());

		// Set template uri for this exchange method
		$this->getUri()->setTemplateUri('http://download.finance.yahoo.com/d/quotes.csv?s={%FROMCURRENCY%}{%TOCURRENCY%}=X&f=sl1d1t1ba&e=.csv');

		// Set http method for this exchange method
		$this->getHttpClient()->setHttpMethod('GET');
	}

	public function getExchangeRate()
	{
		$values = explode(',', $this->getResponse()->getBody());

		if (!is_array($values) || !isset($values[1]))
			throw new Exception\ResponseException('Exchange rate not found');

		return (float) $values[1];
	}
}
