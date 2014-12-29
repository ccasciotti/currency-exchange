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

use CurrencyExchange\Currency\Downloader;

/**
 * Abstract class for every adapter, has only getter and setter for CurrencyExchange\Currency\Downloader instance
 * 
 * @package CurrencyExchange
 */
abstract class AdapterAbstract implements AdapterInterface
{
	/**
	 * @var CurrencyExchange\Currency\Downloader
	 */
	protected $_downloader = null;

	/**
	 * Returns CurrencyExchange\Currency\Downloader instance
	 * 
	 * @return CurrencyExchange\Currency\Downloader
	 */
	public function getDownloader()
	{
		return $this->_downloader;
	}

	/**
	 * Sets CurrencyExchange\Currency\Downloader instance
	 * 
	 * @param CurrencyExchange\Currency\Downloader $downloader
	 * @return CurrencyExchange\Currency\Adapter\AdapterAbstract
	 */
	public function setDownloader(Downloader $downloader)
	{
		$this->_downloader = $downloader;
		return $this;
	}
}
