<?php

/**
 * CurrencyExchange
 * 
 * A library to retrieve currency exchanges using several web services
 * 
 * @link https://github.com/ccasciotti/currency-exchange
 * @license http://www.gnu.org/licenses/gpl-3.0.txt
 */

namespace CurrencyExchange\Exchanger;

use CurrencyExchange\Currency\Currency;
use CurrencyExchange\Factory\ServiceFactory;
use CurrencyExchange\Service\AbstractService;

/**
 * Main class that retrieve exchange rates from the current web service set
 * 
 * @package CurrencyExchange
 * @final
 */
final class Exchanger
{
	/**
	 * @var AbstractService|null Current exchange service
	 */
	protected ?AbstractService $service = null;

	/**
	 * Constructor invokes setService
	 * 
	 * @param AbstractService|string|null $service The exchange service used for getting exchange rate
	 */
	public function __construct(AbstractService|string $service = null)
	{
		$this->setService($service);
	}

	/**
	 * Returns service object
	 * 
	 * @return AbstractService
	 */
	public function getService(): AbstractService
	{
		return $this->service;
	}

	/**
	 * Invokes factory method to instantiates a new Exchange Service
	 * 
	 * @param string|AbstractService|null $service The exchange service used for getting exchange rate
	 * @return $this
	 */
	public function setService(AbstractService|string $service = null): Exchanger
    {
		$this->service = ServiceFactory::create($service);
		return $this;
	}

    /**
     * Get current exchange rate of selected method
     *
     * @param string $fromCode Currency code according to the format of 3 uppercase characters
     * @param string $toCode Currency code according to the format of 3 uppercase characters
     * @param string|null $date
     * @return float
     */
	public function getExchangeRate(string $fromCode, string $toCode, ?string $date = null): float
    {
		$this->getService()
			->getUri()
			->setFromCurrency(new Currency($fromCode))
			->setToCurrency(new Currency($toCode));

		return $date ?
            $this->getService()->getHistoricalExchangeRate($date) :
            $this->getService()->getExchangeRate()
        ;
	}
}
