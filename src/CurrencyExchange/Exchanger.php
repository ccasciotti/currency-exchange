<?php

namespace CurrencyExchange;

/**
 * Class that make exchanges, you can select your preferred exchange method by using setMethod() method, 
 * otherwise it will use GrandTrunk method by default
 */
class Exchanger
{
	/**
	 * @var CurrencyExchange\Methods\AbstractMethod current exchange method
	 */
	protected $_method = null;

	/**
	 * Constructor that invokes setMethod
	 * 
	 * @param object|string|null $method The exchange method used for getting exchange rate. If null, it will be used the default exchange method class
	 * @return void
	 */
	public function __construct($method = null)
	{
		$this->setMethod($method);
	}

	/**
	 * Returns method object
	 * 
	 * @return CurrencyExchange\Methods\AbstractMethod
	 */
	public function getMethod()
	{
		return $this->_method;
	}

	/**
	 * Invokes factory method to instantiates a new Exchange Method object
	 * 
	 * @param object|string|null $method The exchange method used for getting exchange rate. If null, it will be used the default exchange method class
	 * @return CurrencyExchange\Exchanger
	 */
	public function setMethod($method = null)
	{
		$this->_method = Methods\Factory::create($method);
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
		$this->getMethod()->getHttpClient()->setProxy($proxy);
		return $this;
	}

	/**
	 * Set currency codes, retrieve the exchange rate, and it multiplies to the $amount parameter.
	 * 
	 * @param float $amount The amount to exchange
	 * @param string $fromCode Currency code according to the format of 3 uppercase characters
	 * @param string $toCode Currency code according to the format of 3 uppercase characters
	 * @throws CurrencyExchange\Exception\InvalidArgumentException
	 * @return float
	 */
	public function exchange($amount, $fromCode, $toCode)
	{
		if (!$fromCode || !is_string($fromCode))
			throw new Exception\InvalidArgumentException('"From code" must be supplied and must be a string');

		if (!$toCode || !is_string($toCode))
			throw new Exception\InvalidArgumentException('"To code" must be supplied and must be a string');

		$this->getMethod()->getUri()->setFromCurrency($fromCode)->setToCurrency($toCode);

		return (float) $this->getMethod()->getExchangeRate() * (float) $amount;
	}
}
