<?php declare(strict_types=1);

/*
 * This file is part of the CVeeHub application.
 *
 * © Stefan Petcu <contact@stefanpetcu.com>
 *
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 */

namespace CVeeHub\Infrastructure\Provider;

use CVeeHub\Infrastructure\Container\Definition\ApplicationDefinition;
use CVeeHub\Infrastructure\Container\Definition\ConsoleDefinition;
use CVeeHub\Infrastructure\Container\Definition\DatabasePopulatorDefinition;
use CVeeHub\Infrastructure\Container\Definition\DoctrineDefinition;
use CVeeHub\Infrastructure\Container\Definition\EntityPublicIdGeneratorDefinition;
use CVeeHub\Infrastructure\Container\Definition\ErrorHandlerDefinition;
use CVeeHub\Infrastructure\Container\Definition\RepositoryDefinition;
use CVeeHub\Infrastructure\Container\Definition\ValidatorDefinition;
use CVeeHub\Infrastructure\Provider\Contract\ProviderInterface;

/**
 * Provides application's definitions.
 */
class ApplicationProvider implements ProviderInterface
{
    /**
     * @inheritdoc
     */
    public function getDefinitions(): array
    {
        return [
            new DoctrineDefinition(),
            new RepositoryDefinition(),
            new ConsoleDefinition(),
            new ErrorHandlerDefinition(),
            new DatabasePopulatorDefinition(),
            new EntityPublicIdGeneratorDefinition(),
            new ApplicationDefinition()
        ];
    }
}
