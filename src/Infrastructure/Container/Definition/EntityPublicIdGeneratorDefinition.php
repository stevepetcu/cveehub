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

use CVeeHub\Infrastructure\Generator\AlphanumericHashGenerator;
use CVeeHub\Infrastructure\Generator\EntityPublicIdGenerator;
use DI\Definition\Source\DefinitionArray;

class EntityPublicIdGeneratorDefinition extends DefinitionArray
{
    public function __construct()
    {
        $definitions = [
            EntityPublicIdGenerator::class => function () {
                return new EntityPublicIdGenerator(new AlphanumericHashGenerator(), 17);
            }
        ];

        parent::__construct($definitions);
    }
}
