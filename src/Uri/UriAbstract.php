<?php

/**
 * CurrencyExchange
 * 
 * A library to retrieve currency exchanges using several web services
 * 
 * @link https://github.com/teknoman/currency-exchange
 * @license http://www.gnu.org/licenses/gpl-3.0.txt
 */

namespace CurrencyExchange\Uri;

use InvalidArgumentException;
use CurrencyExchange\Currency\Currency;
use CurrencyExchange\Http\Request as HttpRequest;

/**
 * Abstract Uri class, it contains commons methods for each uri type
 * 
 * @package CurrencyExchange
 * @abstract
 */
abstract class UriAbstract
{
	/**
	 * @var string The template uri that must be set with the http uri of web service
	 */
	protected $_templateUri = null;

	/**
	 * @var string The final uri with the $_fromCurrency and $_toCurrency set
	 */
	protected $_uri = null;

	/**
	 * @var string Http type for this Uri (GET or POST)
	 */
	protected $_type = null;

	/**
	 * @var CurrencyExchange\Currency\Currency
	 */
	protected $_fromCurrency = null;

	/**
	 * @var CurrencyExchange\Currency\Currency
	 */
	protected $_toCurrency = null;

	/**
	 * Constructor invokes setType method
	 * 
	 * @param string $type
	 */
	public function __construct($type)
	{
		$this->setType($type);
	}

	/**
	 * @return string
	 */
	public function getType()
	{
		return $this->_type;
	}

    /**
     * @return string
     */
    public function getTemplateUri()
    {
        return $this->_templateUri;
    }

    /**
	 * @return CurrencyExchange\Currency\Currency
	 */
	public function getFromCurrency()
	{
		return $this->_fromCurrency;
	}

	/**
	 * @return CurrencyExchange\Currency\Currency
	 */
	public function getToCurrency()
	{
		return $this->_toCurrency;
	}

	/**
	 * Sets the type of this Uri, can be GET or POST
	 * 
	 * @param string $type Uri type, can be GET or POST
	 * @return CurrencyExchange\Uri\UriAbstract
     * @throws InvalidArgumentException
	 */
	public function setType($type)
	{
        if (!is_string($type)) {
            throw new InvalidArgumentException('Uri type must be a string, ' . gettype($type) . ' given.');
        }

		if (!HttpRequest::isHttpMethodSupported($type)) {
			throw new InvalidArgumentException('Uri type must be GET or POST, ' . $type . ' given');
		}

		$this->_type = strtoupper((string) $type);
		return $this;
	}

	/**
	 * Set "From Currency" object
	 * 
	 * @param CurrencyExchange\Currency\Currency $currency
	 * @return CurrencyExchange\Uri\UriAbstract
	 */
	public function setFromCurrency(Currency $currency)
	{
		$this->_fromCurrency = $currency;
		return $this;
	}

	/**
	 * Set "To Currency" object
	 * 
	 * @param CurrencyExchange\Currency\Currency $currency
	 * @return CurrencyExchange\Uri\UriAbstract
	 */
	public function setToCurrency(Currency $currency)
	{
		$this->_toCurrency = $currency;
		return $this;
	}

    /**
	 * Returns the final uri with currency codes set
	 * 
     * @abstract
	 * @return string
	 */
	abstract public function getFinalUri();

	/**
	 * Set template uri with currency placeholders (if uri type is GET)
	 * 
     * @abstract
	 * @param string $templateUri
	 * @return CurrencyExchange\Uri\UriAbstract
	 */
	abstract public function setTemplateUri($templateUri);
}
