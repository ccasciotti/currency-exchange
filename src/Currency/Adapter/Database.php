<?php

/**
 * CurrencyExchange
 * 
 * A library to retrieve currency exchanges using several web services
 * 
 * @link https://github.com/teknoman/currency-exchange
 * @license http://www.gnu.org/licenses/gpl-3.0.txt
 */

namespace CurrencyExchange\Currency\Adapter;

use CurrencyExchange\Currency\Adapter\Entity\Currency as CurrencyEntity;
use CurrencyExchange\Currency\Adapter\Database\Connection;
use Doctrine\ORM\Tools\Setup;
use Doctrine\ORM\EntityManager;
use RuntimeException;

/**
 * Concrete class to handle get and set of currency's data in database
 * 
 * @package CurrencyExchange
 */
class Database extends AdapterAbstract
{
    /**
     * @var Doctrine\ORM\EntityManager 
     */
    protected $_entityManager;

    /**
     * @var CurrencyExchange\Currency\Adapter\Database\Connection 
     */
    protected $_connection;

    /**
     * Constructor instantiates a CurrencyExchange\Currency\Adapter\Database\Connection object
     */
    public function __construct()
    {
        $this->_connection = new Connection();
    }

    /**
     * Return Connection object
     * 
     * @return CurrencyExchange\Currency\Adapter\Database\Connection
     */
    public function getConnection()
    {
        return $this->_connection;
    }

    /**
     * Set a new Connection object
     * 
     * @param \CurrencyExchange\Currency\Adapter\CurrencyExchange\Currency\Adapter\Database\Connection $connection
     * @return \CurrencyExchange\Currency\Adapter\Database
     */
    public function setConnection(Connection $connection)
    {
        $this->_connection = $connection;
        return $this;
    }

    /**
     * Creates an EntityManager with the configuration set and return it
     * 
     * @return Doctrine\ORM\EntityManager
     */
    public function getEntityManager()
    {
        if (!$this->_entityManager) {
            $this->_entityManager = EntityManager::create(
                $this->getConnection()->getConfiguration(), 
                Setup::createAnnotationMetadataConfiguration(
                    array(__DIR__ . "/Entity"), 
                    false, 
                    null,
                    null,
                    false
                )
            );
        }

        return $this->_entityManager;
    }

    /**
     * Set a Doctrine EntityManager
     * 
     * @param Doctrine\ORM\EntityManager $entityManager
     * @return \CurrencyExchange\Currency\Adapter\Database
     */
    public function setEntityManager(EntityManager $entityManager)
    {
        $this->_entityManager = $entityManager;
        return $this;
    }

    /**
     * Empty currency table
     * 
     * @return mixed
     */
    public function emptyTable()
    {
        // empty table using Doctrine DQL
        $query = $this->getEntityManager()->createQuery('DELETE \CurrencyExchange\Currency\Adapter\Entity\Currency');
        return $query->execute();
    }

    /**
	 * Implementation of CurrencyExchange\Currency\Adapter\AdapterInterface::getData
	 * 
	 * @throws RuntimeException
	 * @return array
	 */
    public function getData()
	{
		$currencyRepository = $this->getEntityManager()->getRepository('\CurrencyExchange\Currency\Adapter\Entity\Currency');
        return $currencyRepository->findAll();
	}

    /**
	 * Implementation of CurrencyExchange\Currency\Adapter\AdapterInterface::saveData
	 * 
	 * @throws RuntimeException
	 * @return CurrencyExchange\Currency\Adapter\Database
	 */
	public function saveData()
	{
        if ($this->emptyTable() === false) {
            throw new RuntimeException('Cannot empty table, an error has occurred');
        }

        $data = $this->getDownloader()->makeRequest()->getCurrencyData();

        $currencies = json_decode($data);
        foreach ($currencies as $currency) {
            $currencyEntity = new CurrencyEntity();
            $currencyEntity->hydrate($currency);

            // inform doctrine that has to handle this entity
            $this->getEntityManager()->persist($currencyEntity);
        }

        // commit to database
        $this->getEntityManager()->flush();
		return $this;
	}
}