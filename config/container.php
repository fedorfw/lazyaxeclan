<?php

use Doctrine\ORM\Configuration;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Mapping\Driver\XmlDriver;
use Doctrine\Persistence\Mapping\Driver\SymfonyFileLocator;
use users\Domain\Interfaces\ConfirmTokenRepositoryInterface;
use yii\di\Container;

return [
    EntityManager::class => function (Container $container) {
        $config = new Configuration();
//        $config->setSQLLogger(new EchoSQLLogger());

        $driver = new XmlDriver(new SymfonyFileLocator([

            __DIR__ . '/../modules/users/Infrastructure/Mappings' => 'users\Domain\Entities',
            __DIR__ . '/../modules/users/Infrastructure/Mappings/ValueObjects' => 'users\Domain\ValueObjects',

            __DIR__ . '/../modules/products/Infrastructure/Mappings' => 'products\Domain\Entities',
            __DIR__ . '/../modules/products/Infrastructure/Mappings/ValueObjects' => 'products\Domain\ValueObjects',

        ], 'Mapping.xml'));
        $config->setMetadataDriverImpl($driver);
        $config->setProxyDir(__DIR__ . '/../runtime/proxies');
        $config->setProxyNamespace('Proxies');
        $config->setAutoGenerateProxyClasses(true);


        $dbConfig = require __DIR__ . '/db_doctrine.php';
        return EntityManager::create([
            'dbname' => $dbConfig['dbname'],
            'user' => $dbConfig['username'],
            'password' => $dbConfig['password'],
            'host' => $dbConfig['host'],
            'driver' => 'pdo_mysql',
            'charset' => 'utf8mb4',
            'driverOptions' => [
                PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8mb4'"
            ]
        ], $config);
    },


    // USERS MODULE
    \users\Domain\Interfaces\UserRepositoryInterface::class => function (Container $container) {
        return $container->get(\users\Infrastructure\Repositories\UserRepository::class);
    },
    ConfirmTokenRepositoryInterface::class => function (Container $container) {
        return $container->get(\users\Infrastructure\Repositories\ConfirmTokenRepository::class);
    },
    \users\Domain\Interfaces\EmailServiceInterface::class => function (Container $container) {
        return $container->get(\users\Domain\Services\EmailService::class);
    },
    // PRODUCTS MODULE
    \products\Domain\Interfaces\ProductRepositoryInterface::class => function (Container $container) {
        return $container->get(\products\Infrastructure\Repositories\ProductRepository::class);
    }

];