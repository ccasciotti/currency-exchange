<?php

namespace CurrencyExchangeTest\Service;

class YahooFinanceTest extends \PHPUnit_Framework_TestCase
{
	/** @var CurrencyExchange\Service\YahooFinance */
	protected $_service = null;

	/** @var float */
	protected $_rate = null;

	public function setUp()
	{
		$service = new \CurrencyExchange\Service\YahooFinance();
		$service->getUri()->setFromCurrency(new \CurrencyExchange\Currency\Currency('EUR'));
		$service->getUri()->setToCurrency(new \CurrencyExchange\Currency\Currency('USD'));
		$this->_rate = $service->getExchangeRate();
		$this->_service = $service;
	}

	/**
	 * Tests if YahooFinance url is achievable
	 */
	public function testYahooFinanceUrlIsAchievable()
	{
		$this->assertEquals(200, $this->_service->getHttpClient()->getResponse()->getStatusCode());
	}

	public function testResponseIsValid()
	{
		$this->assertGreaterThan(0.0, $this->_rate);
	}
}
