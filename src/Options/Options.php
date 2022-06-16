<?php

/**
 * CurrencyExchange
 * 
 * A library to retrieve currency exchanges using several web services
 * 
 * @link https://github.com/ccasciotti/currency-exchange
 * @license http://www.gnu.org/licenses/gpl-3.0.txt
 */

namespace CurrencyExchange\Options;

use InvalidArgumentException;

/**
 * Class for handling general options
 * 
 * @package CurrencyExchange
 */
final class Options
{
	/**
	 * @var array
	 */
	protected array $container;

	/**
	 * Initialize option's array
	 */
	public function __construct()
	{
		$this->container = [];
	}

	/**
	 * Returns all options
	 * 
	 * @return array
	 */
	public function getAll(): array
    {
		return $this->container;
	}

	/**
	 * Retrieve one option
	 * 
	 * @param mixed $option
	 * @return mixed
     * @throws InvalidArgumentException
	 */
	public function get(mixed $option): mixed
    {
		if (!is_scalar($option)) {
			throw new InvalidArgumentException('Option must be a scalar value, ' . gettype($option) . ' given');
		}

        return $this->container[$option] ?? null;
	}

	/**
	 * Add option
	 * 
	 * @param mixed $option
	 * @param mixed $value
	 * @param boolean $replace if true, the existent value of $option will be replaced
	 * @return $this
     * @throws InvalidArgumentException
	 */
	public function add(mixed $option, mixed $value, bool $replace = false): Options
    {
        if (!is_scalar($option)) {
			throw new InvalidArgumentException('Option must be a scalar value, ' . gettype($option) . ' given');
		}

		if (!array_key_exists($option, $this->container) || $replace === true) {
			$this->container[$option] = $value;
		}

		return $this;
	}

	/**
	 * Remove option
	 * 
	 * @param mixed $option
	 * @return $this
     * @throws InvalidArgumentException
	 */
	public function remove(mixed $option): Options
    {
		if (!is_scalar($option)) {
			throw new InvalidArgumentException('Option must be a scalar value, ' . gettype($option) . ' given');
		}

		if (array_key_exists($option, $this->container)) {
			unset($this->container[$option]);
		}

		return $this;
	}

	/**
	 * Sets array of options
	 * 
	 * @param array $options
     * @param bool $replace If true, an existent option will be overwritten
	 * @return $this
	 */
	public function setOptions(array $options, bool $replace = false): Options
    {
		foreach ($options as $option => $value) {
            $this->add($option, $value, $replace);
        }

		return $this;
	}

	/**
	 * Resets options
	 * 
	 * @return $this
	 */
	public function clear(): Options
    {
		$this->container = [];
		return $this;
	}
}
