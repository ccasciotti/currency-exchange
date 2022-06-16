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
 * Class used to handle uri of each exchange method that uses uri with Http POST mode
 * 
 * @package CurrencyExchange
 */
class PostUri extends AbstractUri
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

		$this->uri = $this->templateUri;
		return $this->uri;
	}

	/**
	 * Set template uri
	 * 
	 * @param string $templateUri
	 * @return $this
	 */
	public function setTemplateUri(string $templateUri): static
    {
		$this->templateUri = $templateUri;
		return $this;
	}
}
