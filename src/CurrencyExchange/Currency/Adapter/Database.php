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
use Zend\Json\Json;

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
     * @return CurrencyExchange\Currency\Adapter\Database\Connection
     */
    public function getConnection()
    {
        return $this->_connection;
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
                Setup::createAnnotationMetadataConfiguration(array(__DIR__ . "/Entity"), false)
            );
        }

        return $this->_entityManager;
    }

    /**
     * Set an EntityManager
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
	 * @return CurrencyExchange\Currency\Adapter\File
	 */
	public function saveData()
	{
		if ($this->getDownloader() === null) {
			throw new RuntimeException('Cannot save data, downloader not set');
		}

        if (!$this->emptyTable()) {
            throw new RuntimeException('Cannot empty table, an error has occurred');
        }

        $data = $this->getDownloader()->makeRequest()->getCurrencyData();

        $currencies = Json::decode($data);
        foreach ($currencies as $currency) {
            $currencyEntity = new CurrencyEntity();
            $currencyEntity->hydrate($currency);
            $this->getEntityManager()->persist($currencyEntity);
        }
        
        $this->getEntityManager()->flush();
		return $this;
	}
}