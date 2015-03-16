<?php

namespace CurrencyExchangeTest\Currency\Adapter\Database;

use CurrencyExchange\Options;
use CurrencyExchange\Currency\Adapter\Database\Connection;

class ConnectionTest extends \PHPUnit_Framework_TestCase
{
    public function testIsConnectionSupportedReturnsTrueIfSqliteConnectionIsSupplied()
    {
        $connection = new Connection();
        $connection->setConnectionType(Connection::DB_CONNECTION_SQLITE);

        $this->assertTrue($connection->isConnectionSupported());
    }

    public function testIsConnectionSupportedReturnsTrueIfMysqlConnectionIsSupplied()
    {
        $connection = new Connection();
        $connection->setConnectionType(Connection::DB_CONNECTION_MYSQL);

        $this->assertTrue($connection->isConnectionSupported());
    }

    public function testIsConnectionSupportedReturnsFalseIfUnsupportedConnectionIsSupplied()
    {
        $connection = new Connection();
        $connection->setConnectionType('unknown_connection');

        $this->assertFalse($connection->isConnectionSupported());
    }

    public function testGetConfigurationThrowsInvalidArgumentExceptionWhenSqlitePathIsNotSupplied()
    {
        $this->setExpectedException('InvalidArgumentException');

        $connection = new Connection();
        $connection->setConnectionType(Connection::DB_CONNECTION_SQLITE);

        $connection->getConfiguration();
    }

    public function testGetConfigurationReturnsArrayWithExpectedKeysWhenAllSqliteRequestedParametersAreSupplied()
    {
        $options = new Options();
        $options->addOption('path', 'sqlite-db-path');

        $connection = new Connection();
        $connection->setConnectionType(Connection::DB_CONNECTION_SQLITE);
        $connection->setOptions($options);

        $config = $connection->getConfiguration();

        $this->assertArrayHasKey('driver', $config);
        $this->assertArrayHasKey('path', $config);
        $this->assertEquals(Connection::DB_CONNECTION_SQLITE, $config['driver']);
    }

    public function testGetConfigurationReturnsArrayWithExpectedKeysWhenAllMysqlRequestedParametersAreSupplied()
    {
        $options = new Options();
        $options->addOption('host', 'mysql-host');
        $options->addOption('user', 'mysql-user');
        $options->addOption('password', 'mysql-user-password');
        $options->addOption('dbname', 'mysql-dbname');

        $connection = new Connection();
        $connection->setConnectionType(Connection::DB_CONNECTION_MYSQL);
        $connection->setOptions($options);

        $config = $connection->getConfiguration();

        $this->assertArrayHasKey('driver', $config);
        $this->assertArrayHasKey('host', $config);
        $this->assertArrayHasKey('user', $config);
        $this->assertArrayHasKey('password', $config);
        $this->assertArrayHasKey('dbname', $config);
        $this->assertEquals(Connection::DB_CONNECTION_MYSQL, $config['driver']);
    }
}