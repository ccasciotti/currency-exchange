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

/**
 * @package CurrencyExchange
 */
interface ServiceInterface
{
    /**
     * Returns the exchange rate value
     *
     * @return float
     */
    public function getExchangeRate(): float;

    /**
     * Returns the exchange rate value for a specific date
     *
     * @param string $date
     * @return float
     */
    public function getHistoricalExchangeRate(string $date): float;
}