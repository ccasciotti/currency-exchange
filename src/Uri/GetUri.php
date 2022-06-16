<?php

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

/**
 * Class used to handle uri of each exchange service that uses uri with Http GET mode
 * 
 * @package CurrencyExchange
 */
class GetUri extends AbstractUri
{
	/**
	 * Returns the final uri with currency codes set
	 * 
	 * @return string
     * @throws InvalidArgumentException
	 */
	public function getFinalUri(): string
    {
		if (!$this->getTemplateUri()) {
			throw new InvalidArgumentException('Template Uri not set');
		}

		if (!$this->getFromCurrency()) {
			throw new InvalidArgumentException('"From Currency" not set');
		}

		if (!$this->getToCurrency()) {
			throw new InvalidArgumentException('"To Currency" not set');
		}

		$search = ['{%FROMCURRENCY%}', '{%TOCURRENCY%}'];
		$replace = [$this->getFromCurrency()->getCode(), $this->getToCurrency()->getCode()];

		$this->uri = str_replace($search, $replace, $this->getTemplateUri());
		return $this->uri;
	}

	/**
	 * Set template uri with currency placeholders
	 * 
	 * @param string $templateUri
	 * @return $this
     * @throws InvalidArgumentException
	 */
	public function setTemplateUri(string $templateUri): static
    {
		if (!str_contains($templateUri, '{%FROMCURRENCY%}')) {
			throw new InvalidArgumentException('Cannot find "From Currency" placeholder');
		}

		if (!str_contains($templateUri, '{%TOCURRENCY%}')) {
			throw new InvalidArgumentException('Cannot find "To Currency" placeholder');
		}

		$this->templateUri = $templateUri;
		return $this;
	}
}
