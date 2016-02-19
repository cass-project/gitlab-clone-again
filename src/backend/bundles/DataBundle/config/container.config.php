<?php
namespace Data;

use Data\Factory\DoctrineEntityManagerFactory;
use Doctrine\ORM\EntityManager;

return [
    'zend_service_manager' => [
        'factories' => [
            EntityManager::class => DoctrineEntityManagerFactory::class
        ],

        'services' => [
            'DoctrineConfig' => require(__DIR__ . '/doctrine.config.php')
        ]
    ]
];