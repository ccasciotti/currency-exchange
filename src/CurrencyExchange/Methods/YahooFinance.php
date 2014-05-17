<?php

namespace CurrencyExchange\Methods;

use CurrencyExchange\Exception;

class YahooFinance extends AbstractMethod
{
	protected $_templateUri = 'http://download.finance.yahoo.com/d/quotes.csv?s={%FROMCURRENCYCODE%}{%TOCURRENCYCODE%}=X&f=sl1d1t1ba&e=.csv';

	public function getExchangeRate()
	{
		$values = explode(',', $this->getResponse()->getBody());

		if (!isset($values[1]))
			throw new Exception\InvalidArgumentException('Exchange rate not found');

		return floatval($values[1]);
	}
}
