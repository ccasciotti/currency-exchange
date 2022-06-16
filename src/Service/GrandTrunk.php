<?php

declare(strict_types=1);

/**
 * CurrencyExchange
 * 
 * A library to retrieve currency exchanges using several web services
 * 
 * @link https://github.com/ccasciotti/currency-exchange
 * @license http://www.gnu.org/licenses/gpl-3.0.txt
 */

namespace CurrencyExchange\Service;

use CurrencyExchange\Exception\ParseException;
use CurrencyExchange\Exception\ResponseException;
use CurrencyExchange\Http\Request as HttpRequest;
use CurrencyExchange\Factory\UriFactory;
use CurrencyExchange\Uri\GetUri;
use GuzzleHttp\Exception\GuzzleException;

/**
 * Concrete class to handle webservice from GrandTrunk
 * 
 * @package CurrencyExchange
 */
class GrandTrunk extends AbstractService
{
    protected const BASE_DOMAIN = 'https://currencies.apps.grandtrunk.net';

    /**
     * GrandTrunk Constructor
     */
	public function __construct()
	{
		/** @var GetUri */
		$uri = UriFactory::create(HttpRequest::HTTP_GET);

		// Instantiates and initializes HttpClient and Uri objects
		parent::__construct($uri);
	}

    /**
     * @inheritdoc
     * @throws GuzzleException
     * @throws ParseException
     * @throws ResponseException
     */
	public function getExchangeRate(): float
	{
        $this->getUri()->setTemplateUri(static::BASE_DOMAIN . '/getlatest/{%FROMCURRENCY%}/{%TOCURRENCY%}');

		return $this->getRate();
	}

    /**
     * @inheritdoc
     * @throws GuzzleException
     * @throws ParseException
     * @throws ResponseException
     */
    public function getHistoricalExchangeRate(string $date): float
    {
        $templateUri = sprintf(
            static::BASE_DOMAIN . '/getrate/%s/{%%FROMCURRENCY%%}/{%%TOCURRENCY%%}',
            $date
        );

        $this->getUri()->setTemplateUri($templateUri);

        return $this->getRate();
    }

    /**
     * @return float
     * @throws GuzzleException
     * @throws ParseException
     * @throws ResponseException
     */
    private function getRate(): float
    {
        $rate = $this->getResponseContent()?->getBody()->getContents();

        if (!$rate) {
            throw new ParseException('Exchange rate not found');
        }

        return (float) $rate;
    }
}
