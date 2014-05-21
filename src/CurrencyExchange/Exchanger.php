<?php

namespace CurrencyExchange;

/**
 * Class that make exchanges, you can select your preferred exchange method by using setMethod() method, otherwise it will use GrandTrunk method by default
 */
class Exchanger
{
	/**
	 * @var $_defaultMethodClass the default exchange method class
	 */
	protected $_defaultMethodClass = '\CurrencyExchange\Methods\GrandTrunk';
	
	/**
	 * @var $_method the exchange method object
	 */
	protected $_method = null;

	/**
	 * Constructor
	 * @param object|string|null $method The exchange method used for getting exchange rate. It can be an object, a string or null. If null, it will be used the default exchange method class
	 */
	public function __construct($method = null)
	{
		$this->setMethod($method);
	}

	/**
	 * Returns $_method object
	 * @return CurrencyExchange\Methods\AbstractMethod
	 */
	public function getMethod()
	{
		return $this->_method;
	}

	/**
	 * @param object|string|null $method The exchange method used for getting exchange rate. It can be an object, a string or null. If null, it will be used the default exchange method class
	 * @return CurrencyExchange\Exchanger
	 */
	public function setMethod($method = null)
	{
		if (is_string($method))
		{
			if (!class_exists($method))
				throw new Exception\InvalidMethodException('Exchange method not found');

			$method = new $method();

			if (!($method instanceof Methods\AbstractMethod))
				throw new Exception\InvalidMethodException('Invalid exchange method supplied');

			$this->_method = $method;
		}
		else if (is_object($method) && $method instanceof Methods\AbstractMethod)
			$this->_method = $method;
		else
			$this->_method = new $this->_defaultMethodClass();

		return $this;
	}
	
	/**
	 * Set proxy
	 * @param string $proxy The proxy string in form host:port
	 * @return Exchanger
	 */
	public function setProxy($proxy)
	{
		$this->getMethod()->getHttpClient()->setProxy($proxy);
		return $this;
	}

	/**
	 * Make call to exchange() method of the current instantiated exchange method that downloads and retrive the exchange rates, then it multiplies to the $amount parameter.
	 * @param float $amount The amount to exchange
	 * @param string|null $fromCode Optional if you have already set in method object, if passed it will override the $fromCurrencyCode of method instance
	 * @param string|null $toCode Optional if you have already set in method object, if passed it will override the $toCurrencyCode of method instance
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
