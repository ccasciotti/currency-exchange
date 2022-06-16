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

namespace CurrencyExchange\Exception;

use Exception;

/**
 * Thrown when the code of http response is not 200
 * 
 * @package CurrencyExchange
 */
class ResponseException extends Exception
{

}
