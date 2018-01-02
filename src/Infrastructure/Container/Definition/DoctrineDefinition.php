<?php declare(strict_types=1);

/*
 * This file is part of the CVeeHub application.
 *
 * © Stefan Petcu <contact@stefanpetcu.com>
 *
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 */

namespace CVeeHub\Infrastructure\Container\Definition;

use DI\Definition\Source\DefinitionArray;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Tools\Setup;
use Psr\Container\ContainerInterface;

/**
 * Provides the DI Container with the definition for Doctrine's Entity Manager.
 */
class DoctrineDefinition extends DefinitionArray
{
    public function __construct()
    {
        $definitions = [
            EntityManagerInterface::class => function (ContainerInterface $container) {
                $dbConfig = $container->get('doctrine');

                $config = Setup::createAnnotationMetadataConfiguration(
                    [
                        $dbConfig['meta']['entity_path']
                    ],
                    $dbConfig['meta']['auto_generate_proxies'],
                    $dbConfig['meta']['proxy_path'],
                    $dbConfig['meta']['cache_class'] ? new $dbConfig['meta']['cache_class'] : null,
                    false
                );

                $connection = $dbConfig['connections']['master'];

                return EntityManager::create($connection, $config);
            },
        ];

        parent::__construct($definitions);
    }
}
