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
use Psr\Container\ContainerInterface;
use Slim\App;

class ApplicationDefinition extends DefinitionArray
{
    public function __construct()
    {
        $definitions = [
            App::class => function (ContainerInterface $container) {
                return new App($container);
            }
        ];

        parent::__construct($definitions);
    }
}
