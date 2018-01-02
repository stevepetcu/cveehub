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

use CVeeHub\Infrastructure\Testing\SqliteDatabasePopulator;
use DI\Definition\Source\DefinitionArray;
use PDO;
use Psr\Container\ContainerInterface;

class DatabasePopulatorDefinition extends DefinitionArray
{
    public function __construct()
    {
        $definitions = [
            SqliteDatabasePopulator::class => function (ContainerInterface $container) {
                $sqlitePath = $container->get('doctrine')['connections']['master']['path'];

                return new SqliteDatabasePopulator(
                    new PDO("sqlite:$sqlitePath")
                );
            }
        ];

        parent::__construct($definitions);
    }
}
