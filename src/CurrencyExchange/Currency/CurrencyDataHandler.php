<?php

/**
 * CurrencyExchange
 * 
 * A library to retrieve currency exchanges using several web services
 * 
 * @link https://github.com/teknoman/currency-exchange
 * @license http://www.gnu.org/licenses/gpl-3.0.txt
 */

namespace CurrencyExchange\Currency;

use CurrencyExchange\Currency\Adapter;
use CurrencyExchange\Currency\Currency;

/**
 * Class used to handle currency's data adapter
 * 
 * @package CurrencyExchange
 */
class CurrencyDataHandler
{
	/**
	 * @var CurrencyExchange\Currency\Adapter\AdapterInterface
	 */
	protected $_adapter = null;

	/**
	 * @var array
	 */
	protected $_data = null;

	/**
	 * Returns currency's data adapter
	 * 
	 * @return CurrencyExchange\Currency\Adapter\AdapterInterface
	 */
	public function getAdapter()
	{
		if (!$this->_adapter) {
			$this->setAdapter();
		}

		return $this->_adapter;
	}

	/**
	 * Sets currency's data adapter
	 * 
	 * @param CurrencyExchange\Currency\Adapter\AdapterInterface $adapter
	 * @return CurrencyExchange\Currency\CurrencyData
	 */
	public function setAdapter(Adapter\AdapterInterface $adapter = null)
	{
		if ($adapter === null) {
			$adapter = new Adapter\File();
		}

		$this->_adapter = $adapter;
		return $this;
	}

	/**
	 * Checks if the supplied currency code is ISO 4217 compliant
	 * 
	 * @param string $code
	 * @return boolean
	 */
	public function isValid($code)
	{
		$currency = new Currency($code);

		if ($this->_data === null) {
			$this->_data = $this->getAdapter()->getData();
		}

		$codes = array_map(function($element) {
			return $element->AlphabeticCode;
		}, $this->_data);

		return in_array($currency->getCode(), $codes);
	}
}
