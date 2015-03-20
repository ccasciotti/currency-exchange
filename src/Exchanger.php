<?php

/**
 * CurrencyExchange
 * 
 * A library to retrieve currency exchanges using several web services
 * 
 * @link https://github.com/teknoman/currency-exchange
 * @license http://www.gnu.org/licenses/gpl-3.0.txt
 */

namespace CurrencyExchange;

use CurrencyExchange\Factory\ServiceFactory;
use CurrencyExchange\Currency\Currency;
use CurrencyExchange\Currency\CurrencyDataHandler;
use InvalidArgumentException;

/**
 * Main class that retrieve exchange rates from the current web service set
 * 
 * @package CurrencyExchange
 */
class Exchanger
{
	/**
	 * @var CurrencyExchange\Service\ServiceAbstract Current exchange service
	 */
	protected $_service = null;

	/**
	 * @var CurrencyExchange\Currency\CurrencyData Currency's data handler
	 */
	protected $_currencyDataHandler = null;

	/**
	 * @var boolean If we need to skip data check or not
	 */
	protected $_skipCurrencyDataCheck = false;

	/**
	 * Constructor invokes setService
	 * 
	 * @param object|string|null $method The exchange service used for getting exchange rate
	 */
	public function __construct($service = null, $skipCurrencyDataCheck = false)
	{
		$this->setService($service);
		$this->setSkipCurrencyDataCheck($skipCurrencyDataCheck);
	}

	/**
	 * Returns service object
	 * 
	 * @return CurrencyExchange\Service\ServiceAbstract
	 */
	public function getService()
	{
		return $this->_service;
	}

	/**
	 * Invokes factory method to instantiates a new Exchange Service
	 * 
	 * @param object|string|null $service The exchange service used for getting exchange rate
	 * @return CurrencyExchange\Exchanger
	 */
	public function setService($service = null)
	{
		$this->_service = ServiceFactory::factory($service);
		return $this;
	}

	/**
	 * Retrieve currency's data handler object
	 * 
	 * @return CurrencyExchange\Currency\CurrencyDataHandler
	 */
	public function getCurrencyDataHandler()
	{
		if (!$this->_currencyDataHandler) {
			$this->setCurrencyDataHandler(new CurrencyDataHandler());
		}

		return $this->_currencyDataHandler;
	}

	/**
	 * Retrieve currency's data handler object
	 * 
	 * @param CurrencyExchange\Currency\CurrencyDataHandler $currencyDataHandler
	 * @return CurrencyExchange\Currency\CurrencyDataHandler
	 */
	public function setCurrencyDataHandler(CurrencyDataHandler $currencyDataHandler)
	{
		$this->_currencyDataHandler = $currencyDataHandler;
		return $this;
	}

	/**
	 * Get skip currency data check flag
	 * 
	 * @return boolean
	 */
	public function getSkipCurrencyDataCheck()
	{
		return $this->_skipCurrencyDataCheck;
	}

	/**
	 * Set skip currency data check
	 * 
	 * @param boolean $skipCurrencyDataCheck
	 * @return CurrencyExchange\Exchanger
	 */
	public function setSkipCurrencyDataCheck($skipCurrencyDataCheck)
	{
		$this->_skipCurrencyDataCheck = (bool) $skipCurrencyDataCheck;
		return $this;
	}

	/**
	 * Set proxy to HttpClient object
	 * 
	 * @param string $proxy The proxy string in form host:port
	 * @return CurrencyExchange\Exchanger
	 */
	public function setProxy($proxy)
	{
		$this->getService()->getHttpClient()->setProxy($proxy);
		return $this;
	}

	/**
	 * Get current exchange rate of selected method
	 * 
	 * @param string $fromCode Currency code according to the format of 3 uppercase characters
	 * @param string $toCode Currency code according to the format of 3 uppercase characters
	 * @throws InvalidArgumentException
	 * @return float
	 */
	public function getExchangeRate($fromCode, $toCode)
	{
		if (!$this->getSkipCurrencyDataCheck()) {
			if (!$this->getCurrencyDataHandler()->isValid($fromCode)) {
				throw new InvalidArgumentException('Currency ' . $fromCode . ' is not a valid currency');
			}

			if (!$this->getCurrencyDataHandler()->isValid($toCode)) {
				throw new InvalidArgumentException('Currency ' . $toCode . ' is not a valid currency');
			}
		}

		$this->getService()
			->getUri()
			->setFromCurrency(new Currency($fromCode))
			->setToCurrency(new Currency($toCode));

		return $this->getService()->getExchangeRate();
	}

	/**
	 * Retrieve the exchange rate, and it multiplies to the $amount parameter.
	 * 
	 * @param float $amount The amount to exchange
	 * @param string $fromCode Currency code according to the format of 3 uppercase characters
	 * @param string $toCode Currency code according to the format of 3 uppercase characters
	 * @return float
	 */
	public function exchange($amount, $fromCode, $toCode)
	{
		return (float) $this->getExchangeRate($fromCode, $toCode) * (float) $amount;
	}
}
