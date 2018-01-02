<?php declare(strict_types=1);

namespace CVeeHub\Test\Integration\Infrastructure\Container\Definition;

use CVeeHub\Infrastructure\Generator\EntityPublicIdGenerator;
use CVeeHub\Test\Contract\AbstractIntegrationTestCase;

/**
 * @covers \CVeeHub\Infrastructure\Container\Definition\EntityPublicIdGeneratorDefinition
 */
class EntityPublicIdGeneratorDefinitionTest extends AbstractIntegrationTestCase
{
    public function testItDefinesTheEntityPublicIdGenerator()
    {
        $this->assertInstanceOf(
            EntityPublicIdGenerator::class,
            $this->container->get(EntityPublicIdGenerator::class)
        );
    }
}
