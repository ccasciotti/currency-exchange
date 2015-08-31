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
	protected $_container;

	/**
	 * Initialize option's array
	 */
	public function __construct()
	{
		$this->_container = [];
	}

	/**
	 * Returns all options
	 * 
	 * @return array
	 */
	public function getAll()
	{
		return $this->_container;
	}

	/**
	 * Retrieve one option
	 * 
	 * @param mixed $option
	 * @return mixed
     * @throws InvalidArgumentException
	 */
	public function get($option)
	{
		if (!is_scalar($option)) {
			throw new InvalidArgumentException('Option must be a scalar value, ' . gettype($option) . ' given');
		}

        return isset($this->_container[$option]) ? 
               $this->_container[$option] : 
               null;
	}

	/**
	 * Add option
	 * 
	 * @param mixed $option
	 * @param mixed $value
	 * @param boolean $replace if true, the existent value of $option will be replaced
	 * @return CurrencyExchange\Options
     * @throws InvalidArgumentException
	 */
	public function add($option, $value, $replace = false)
	{
        if (!is_scalar($option)) {
			throw new InvalidArgumentException('Option must be a scalar value, ' . gettype($option) . ' given');
		}

		if (!array_key_exists($option, $this->_container) || $replace === true) {
			$this->_container[$option] = $value;
		}

		return $this;
	}

	/**
	 * Remove option
	 * 
	 * @param mixed $option
	 * @return CurrencyExchange\Options
     * @throws InvalidArgumentException
	 */
	public function remove($option)
	{
		if (!is_scalar($option)) {
			throw new InvalidArgumentException('Option must be a scalar value, ' . gettype($option) . ' given');
		}

		if (array_key_exists($option, $this->_container)) {
			unset($this->_container[$option]);
		}

		return $this;
	}

	/**
	 * Sets array of options
	 * 
	 * @param array $options
     * @param bool $replace If true, an existent option will be overwritter
	 * @return CurrencyExchange\Options
	 */
	public function setOptions(array $options, $replace = false)
	{
		foreach ($options as $option => $value) {
            $this->add($option, $value, $replace);
        }

		return $this;
	}

	/**
	 * Resets options
	 * 
	 * @return CurrencyExchange\Options
	 */
	public function clear()
	{
		$this->_container = [];
		return $this;
	}
}
