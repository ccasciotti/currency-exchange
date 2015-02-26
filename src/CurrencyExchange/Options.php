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

use InvalidArgumentException;

/**
 * Class for handling general options
 * 
 * @package CurrencyExchange
 */
class Options
{
	/**
	 * @var array
	 */
	protected $_options;

	/**
	 * Initialize option's array
	 */
	public function __construct()
	{
		$this->_options = array();
	}

	/**
	 * Returns all options
	 * 
	 * @return array
	 */
	public function getOptions()
	{
		return $this->_options;
	}

	/**
	 * Retrieve one option
	 * 
	 * @param mixed $option
	 * @throws InvalidArgumentException
	 * @return mixed
	 */
	public function getOption($option)
	{
		if (!is_scalar($option)) {
			throw new InvalidArgumentException('Option must be a scalar value, ' . gettype($option) . ' given');
		}

		if (isset($this->_options[$option])) {
			return $this->_options[$option];
		}

		return false;
	}

	/**
	 * Add option
	 * 
	 * @param mixed $option
	 * @param mixed $value
	 * @param boolean $replace if true, the existent value of $option will be replaced
	 * @return CurrencyExchange\Options
	 */
	public function addOption($option, $value, $replace = false)
	{
        if (!is_scalar($option)) {
			throw new InvalidArgumentException('Option must be a scalar value, ' . gettype($option) . ' given');
		}

        $replace = (bool) $replace;

		if (!array_key_exists($option, $this->_options) || $replace) {
			$this->_options[$option] = $value;
		}

		return $this;
	}

	/**
	 * Remove option
	 * 
	 * @param mixed $option
	 * @throws InvalidArgumentException
	 * @return CurrencyExchange\Options
	 */
	public function removeOption($option)
	{
		if (!is_scalar($option)) {
			throw new InvalidArgumentException('Option must be a scalar value, ' . gettype($option) . ' given');
		}

		if (array_key_exists($option, $this->_options)) {
			unset($this->_options[$option]);
		}

		return $this;
	}

	/**
	 * Sets array of options
	 * 
	 * @param array $options
	 * @return CurrencyExchange\Options
	 */
	public function setOptions(array $options)
	{
		$this->_options = $options;
		return $this;
	}

	/**
	 * Resets options
	 * 
	 * @return CurrencyExchange\Options
	 */
	public function resetOptions()
	{
		$this->_options = array();
		return $this;
	}
}
