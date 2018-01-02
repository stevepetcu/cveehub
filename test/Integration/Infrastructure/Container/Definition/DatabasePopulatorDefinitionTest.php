<?php declare(strict_types=1);

namespace CVeeHub\Test\Integration\Infrastructure\Container\Definition;

use CVeeHub\Infrastructure\Testing\SqliteDatabasePopulator;
use CVeeHub\Test\Contract\AbstractIntegrationTestCase;

/**
 * @covers \CVeeHub\Infrastructure\Container\Definition\DatabasePopulatorDefinition
 */
class DatabasePopulatorDefinitionTest extends AbstractIntegrationTestCase
{
    public function testItDefinesTheDatabasePopulator()
    {
        $this->assertInstanceOf(
            SqliteDatabasePopulator::class,
            $this->container->get(SqliteDatabasePopulator::class)
        );
    }
}
