<?php
namespace Development;

use Development\Factory\Middleware\DumpConfigMiddlewareFactory;
use Development\Factory\Service\DumpConfigServiceFactory;
use Development\Middleware\DumpConfigMiddleware;
use Development\Service\DumpConfigService;

return [
    'zend_service_manager' => [
        'factories' => [
            DumpConfigService::class => DumpConfigServiceFactory::class,
            DumpConfigMiddleware::class => DumpConfigMiddlewareFactory::class
        ]
    ]
];