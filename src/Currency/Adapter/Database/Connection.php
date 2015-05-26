<?php

/**
 * CurrencyExchange
 * 
 * A library to retrieve currency exchanges using several web services
 * 
 * @link https://github.com/teknoman/currency-exchange
 * @license http://www.gnu.org/licenses/gpl-3.0.txt
 */

namespace CurrencyExchange\Currency\Adapter\Database;

use CurrencyExchange\Options;
use InvalidArgumentException;

/**
 * Class that handle doctrine's connection configuration based on db platform
 * 
 * @package CurrencyExchange
 */
class Connection
{
    /**
     * Constant for SQLite connection type
     */
    const DB_CONNECTION_SQLITE = 'pdo_sqlite';

    /**
     * Constant for MySQL connection type
     */
    const DB_CONNECTION_MYSQL = 'pdo_mysql';

    /**
     * @var string 
     */
    protected $_connectionType = null;

    /**
     * @var CurrencyExchange\Options 
     */
    protected $_options = null;

    /**
     * Return CurrencyExchange\Options object
     * 
     * @return CurrencyExchange\Options
     */
    public function getOptions()
    {
        return $this->_options;
    }

    /**
     * Set a new Options object
     * 
     * @param Options $options A Options object
     * @return \CurrencyExchange\Currency\Adapter\Database\Connection
     */
    public function setOptions(Options $options)
    {
        $this->_options = $options;
        return $this;
    }

    /**
     * Return type of database connection
     * 
     * @return string
     */
    public function getConnectionType()
    {
        return $this->_connectionType;
    }

    /**
     * Set connection type
     * 
     * @param string $connectionType
     * @return \CurrencyExchange\Currency\Adapter\Database\Connection
     */
    public function setConnectionType($connectionType)
    {
        $this->_connectionType = $connectionType;
        return $this;
    }

    /**
     * Check if connection type is supported
     * 
     * @return boolean
     */
    public function isConnectionSupported()
    {
        return in_array($this->getConnectionType(), array(
            static::DB_CONNECTION_SQLITE,
            static::DB_CONNECTION_MYSQL,
        ));
    }

    /**
     * Return configuration for Doctrine, based on connection type
     * 
     * @return array
     * @throws InvalidArgumentException
     */
    public function getConfiguration()
    {
        if (!$this->isConnectionSupported()) {
            throw new InvalidArgumentException('Unsupported connection: ' . $this->getConnectionType());
        }

        switch ($this->getConnectionType()) {
            case static::DB_CONNECTION_SQLITE:

                if (!$this->getOptions()->getOption('path')) {
                    throw new InvalidArgumentException('Sqlite database path not supplied');
                }

                break;

            case static::DB_CONNECTION_MYSQL:

                if (!$this->getOptions()->getOption('host')) {
                    throw new InvalidArgumentException('Database host not supplied');
                }

                if (!$this->getOptions()->getOption('user')) {
                    throw new InvalidArgumentException('Database user not supplied');
                }

                if (!$this->getOptions()->getOption('password')) {
                    throw new InvalidArgumentException('Database password not supplied');
                }

                if (!$this->getOptions()->getOption('dbname')) {
                    throw new InvalidArgumentException('Database name not supplied');
                }

                break;
        }

        $this->getOptions()->addOption('driver', $this->getConnectionType());
        return $this->getOptions()->getOptions();
    }
}