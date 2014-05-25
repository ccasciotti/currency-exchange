<?php

namespace CurrencyExchange\Methods;

use CurrencyExchange\Exception;

class GoogleExchangeRate extends AbstractMethod
{
	public function __construct()
	{
		// Initialize HttpClient object
		parent::__construct();

		// Instantiate a new Uri object
		$this->setUri(new \CurrencyExchange\Uri\UriGet());

		// Set template uri for this exchange method
		$this->getUri()->setTemplateUri('http://rate-exchange.appspot.com/currency?from={%FROMCURRENCY%}&to={%TOCURRENCY%}');

		// Set http method for this exchange method
		$this->getHttpClient()->setHttpMethod('GET');
	}

	public function getExchangeRate()
	{
		$object = \Zend\Json\Json::decode($this->getResponse()->getBody());

		if (!isset($object->rate))
			throw new Exception\ResponseException('Exchange rate not found');

		return (float) $object->rate;
	}
}
