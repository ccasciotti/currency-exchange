<?php

namespace CurrencyExchange\Methods;

use CurrencyExchange\Exception;

class GoogleExchangeRate extends AbstractMethod
{
	public function __construct()
	{
		parent::__construct(); // initialize Uri object and HttpClient object

		// Set template uri for this exchange method
		$this->getUri()->setTemplateUri('http://rate-exchange.appspot.com/currency?from={%FROMCURRENCY%}&to={%TOCURRENCY%}');

		// Set http method for this exchange method
		$this->getHttpClient()->setHttpMethod('GET');
	}

	public function getExchangeRate()
	{
		$object = \Zend\Json\Json::decode($this->getResponse()->getBody());

		return (float) $object->rate;
	}
}
