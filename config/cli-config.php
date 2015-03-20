<?php

// Bootstrap and configuration file for doctrine
require_once __DIR__ . '/../tests/bootstrap.php';

use Doctrine\ORM\Tools\Setup;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Tools\Console\ConsoleRunner;

// Create Doctrine ORM configuration for Annotations
$config = Setup::createAnnotationMetadataConfiguration(
    array(__DIR__ . "/../src/Currency/Adapter/Entity"), 
    true,
    null,
    null,
    false
);

// database configuration parameters
$conn = array(
    'driver' => 'pdo_sqlite',
    'path' => sys_get_temp_dir() . '/db.sqlite',
);

// obtaining the entity manager
$entityManager = EntityManager::create($conn, $config);

return ConsoleRunner::createHelperSet($entityManager);