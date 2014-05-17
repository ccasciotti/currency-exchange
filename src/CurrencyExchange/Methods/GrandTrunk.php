<?php

namespace CurrencyExchange\Methods;

use CurrencyExchange\Exception;

class GrandTrunk extends AbstractMethod
{
	protected $_templateUri = 'http://currencies.apps.grandtrunk.net/getlatest/{%FROMCURRENCYCODE%}/{%TOCURRENCYCODE%}';
}
