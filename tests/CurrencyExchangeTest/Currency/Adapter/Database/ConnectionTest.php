<?php

namespace CurrencyExchangeTest\Currency\Adapter\Database;

use CurrencyExchange\Options;
use CurrencyExchange\Currency\Adapter\Database\Connection;

class ConnectionTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @dataProvider providerTestIsConnectionSupportedReturnsTrueIfSupportedConnectionIsSupplied
     */
    public function testIsConnectionSupportedReturnsTrueIfSupportedConnectionIsSupplied($connectionType)
    {
        $connection = new Connection();
        $connection->setConnectionType($connectionType);

        $this->assertTrue($connection->isConnectionSupported());
    }

    public function testIsConnectionSupportedReturnsFalseIfUnsupportedConnectionIsSupplied()
    {
        $connection = new Connection();
        $connection->setConnectionType('unknown_connection');

        $this->assertFalse($connection->isConnectionSupported());
    }

    public function testGetConfigurationThrowsInvalidArgumentExceptionWhenConnectionTypeIsNotSupported()
    {
        $this->setExpectedException('InvalidArgumentException');

        $connection = new Connection();
        $connection->setConnectionType('unknown_connection');

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
        $this->assertEquals('sqlite-db-path', $config['path']);
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
        $this->assertEquals('mysql-host', $config['host']);
        $this->assertEquals('mysql-user', $config['user']);
        $this->assertEquals('mysql-user-password', $config['password']);
        $this->assertEquals('mysql-dbname', $config['dbname']);
    }

    /**
     * @dataProvider providerTestGetConfigurationThrowsInvalidArgumentExceptionWhenDatabaseParameterIsNotSupplied
     */
    public function testGetConfigurationThrowsInvalidArgumentExceptionWhenDatabaseParameterIsNotSupplied($connectionType, array $arrayOptions)
    {
        $this->setExpectedException('InvalidArgumentException');

        $options = new Options();
        $options->setOptions($arrayOptions);

        $connection = new Connection();
        $connection->setConnectionType($connectionType);
        $connection->setOptions($options);

        $connection->getConfiguration();
    }

    public function providerTestGetConfigurationThrowsInvalidArgumentExceptionWhenDatabaseParameterIsNotSupplied()
    {
        return array(
            array(
                Connection::DB_CONNECTION_SQLITE,
                array(
                    // Missing sqlite path
                )
            ),
            array(
                Connection::DB_CONNECTION_MYSQL,
                array(
                    // Missing mysql host
                    'user' => 'mysql-user',
                    'password' => 'mysql-password',
                    'dbname' => 'mysql-dbname',
                )
            ),
            array(
                Connection::DB_CONNECTION_MYSQL,
                array(
                    // Missing mysql user
                    'host' => 'mysql-host',
                    'password' => 'mysql-password',
                    'dbname' => 'mysql-dbname',
                )
            ),
            array(
                Connection::DB_CONNECTION_MYSQL,
                array(
                    // Missing mysql password
                    'host' => 'mysql-host',
                    'user' => 'mysql-user',
                    'dbname' => 'mysql-dbname',
                )
            ),
            array(
                Connection::DB_CONNECTION_MYSQL,
                array(
                    // Missing mysql dbname
                    'host' => 'mysql-host',
                    'user' => 'mysql-user',
                    'password' => 'mysql-password',
                )
            ),
        );
    }

    public function providerTestIsConnectionSupportedReturnsTrueIfSupportedConnectionIsSupplied()
    {
        return array(
            array(Connection::DB_CONNECTION_SQLITE),
            array(Connection::DB_CONNECTION_MYSQL),
        );
    }
}