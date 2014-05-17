<?php

namespace CurrencyExchange\Methods;

use CurrencyExchange\Exception;

class GoogleExchangeRate extends AbstractMethod
{
	protected $_templateUri = 'http://rate-exchange.appspot.com/currency?from={%FROMCURRENCYCODE%}&to={%TOCURRENCYCODE%}';

	public function getExchangeRate()
	{
		$object = \Zend\Json\Json::decode($this->getResponse()->getBody());

		return (float) $object->rate;
	}
}
