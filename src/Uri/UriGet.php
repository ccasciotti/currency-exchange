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

/**
 * Class used to handle uri of each exchange service that uses uri with Http GET mode
 * 
 * @package CurrencyExchange
 */
class UriGet extends UriAbstract
{
	/**
	 * Returns the final uri with currency codes set
	 * 
	 * @throws InvalidArgumentException
	 * @return string
	 */
	public function getFinalUri()
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

		$search = array('{%FROMCURRENCY%}', '{%TOCURRENCY%}');
		$replace = array($this->getFromCurrency()->getCode(), $this->getToCurrency()->getCode());

		$this->_uri = str_replace($search, $replace, $this->getTemplateUri());
		return $this->_uri;
	}

	/**
	 * Set template uri with currency placeholders
	 * 
	 * @param string $templateUri
	 * @throws InvalidArgumentException
	 * @return CurrencyExchange\Uri\UriGet
	 */
	public function setTemplateUri($templateUri)
	{
		$templateUri = (string) $templateUri;

		if (strpos($templateUri, '{%FROMCURRENCY%}') === false) {
			throw new InvalidArgumentException('Cannot find "From Currency" placeholder');
		}

		if (strpos($templateUri, '{%TOCURRENCY%}') === false) {
			throw new InvalidArgumentException('Cannot find "To Currency" placeholder');
		}

		$this->_templateUri = $templateUri;
		return $this;
	}
}
