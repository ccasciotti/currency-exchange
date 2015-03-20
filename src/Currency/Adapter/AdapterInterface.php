<?php

/**
 * CurrencyExchange
 * 
 * A library to retrieve currency exchanges using several web services
 * 
 * @link https://github.com/teknoman/currency-exchange
 * @license http://www.gnu.org/licenses/gpl-3.0.txt
 */

namespace CurrencyExchange\Currency\Adapter;

/**
 * Interface for every Adapter class
 * 
 * @package CurrencyExchange
 */
interface AdapterInterface
{
	/**
	 * Returns currency's data from adapter
	 */
	public function getData();

	/**
	 * Saves currency data
	 */
	public function saveData();
}
