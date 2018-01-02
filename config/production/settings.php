<?php

use Doctrine\Common\Cache\ApcuCache;
use Doctrine\Common\Proxy\AbstractProxyFactory;

return [
    'application.container.cache_class' => ApcuCache::class,
    'doctrine' => [
        'meta' => [
            'auto_generate_proxies' => AbstractProxyFactory::AUTOGENERATE_NEVER,
            'cache_class' => ApcuCache::class,
        ],
    ],
];
