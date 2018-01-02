<?php

use DI\Cache\ArrayCache;
use DI\Container;
use Doctrine\Common\Proxy\AbstractProxyFactory;

return [
    'application.name' => 'CVeeHub',
    'application.version' => '0.1.0',
    'application.source' => 'https://github.com/stevepetcu/cveehub',
    'application.container.class' => Container::class,
    'application.container.cache_class' => ArrayCache::class,
    'doctrine' => [
        'meta' => [
            'entity_path' => PATH_SRC . '/Domain/Entity',
            'proxy_path' => PATH_ROOT . '/var/cache/doctrine/proxies',
            'auto_generate_proxies' => AbstractProxyFactory::AUTOGENERATE_ALWAYS,
            'cache_class' => null,
        ],
        'connections' => [
            'master' => [
                'defaultTableOptions' => [
                    'charset' => 'utf8mb4',
                    'collate' => 'utf8mb4_unicode_ci'
                ],
                'port' => 3306,
                'user' => 'root',
                'password' => 'admin',
                'dbname' => 'cveehub',
                'driver' => 'pdo_mysql',
                'host' => 'cveehub_mysql',
            ]
        ]
    ],
    'settings' => [
        'httpVersion' => '1.1',
        'responseChunkSize' => 4096,
        'determineRouteBeforeAppMiddleware' => false,
        'outputBuffering' => false,
        'displayErrorDetails' => false,
        'addContentLengthHeader' => true,
        'routerCacheFile' => false
    ],
];
