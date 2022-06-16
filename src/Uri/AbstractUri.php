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
abstract class AbstractUri
{
	/**
	 * @var string|null The template uri that must be set with the http uri of web service
	 */
	protected ?string $templateUri = null;

	/**
	 * @var string The final uri with the $_fromCurrency and $_toCurrency set
	 */
	protected string $uri;

	/**
	 * @var string Http type for this Uri (GET or POST)
	 */
	protected string $type;

	/**
	 * @var Currency|null
     */
	protected ?Currency $fromCurrency = null;

	/**
	 * @var Currency|null
     */
	protected ?Currency $toCurrency = null;

	/**
	 * Constructor invokes setType method
	 * 
	 * @param string $type
	 */
	public function __construct(string $type)
	{
		$this->setType($type);
	}

	/**
	 * @return string
	 */
	public function getType(): string
    {
		return $this->type;
	}

    /**
     * @return string|null
     */
    public function getTemplateUri(): ?string
    {
        return $this->templateUri;
    }

    /**
     * @return Currency|null
     */
	public function getFromCurrency(): ?Currency
    {
		return $this->fromCurrency;
	}

    /**
     * @return Currency|null
     */
	public function getToCurrency(): ?Currency
    {
		return $this->toCurrency;
	}

	/**
	 * Sets the type of this Uri, can be GET or POST
	 * 
	 * @param string $type Uri type, can be GET or POST
	 * @return $this
     * @throws InvalidArgumentException
	 */
	public function setType(string $type): static
    {
		if (!HttpRequest::isHttpMethodSupported($type)) {
			throw new InvalidArgumentException('Uri type must be GET or POST, ' . $type . ' given');
		}

		$this->type = strtoupper($type);
		return $this;
	}

	/**
	 * Set "From Currency" object
	 * 
	 * @param Currency $currency
	 * @return $this
	 */
	public function setFromCurrency(Currency $currency): static
    {
		$this->fromCurrency = $currency;
		return $this;
	}

	/**
	 * Set "To Currency" object
	 * 
	 * @param Currency $currency
	 * @return $this
	 */
	public function setToCurrency(Currency $currency): static
    {
		$this->toCurrency = $currency;
		return $this;
	}

    /**
	 * Returns the final uri with currency codes set
	 * 
     * @abstract
	 * @return string
	 */
	abstract public function getFinalUri(): string;

	/**
	 * Set template uri with currency placeholders (if uri type is GET)
	 * 
     * @abstract
	 * @param string $templateUri
	 * @return $this
	 */
	abstract public function setTemplateUri(string $templateUri): static;
}
