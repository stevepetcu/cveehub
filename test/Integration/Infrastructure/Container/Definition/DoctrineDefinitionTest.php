<?php declare(strict_types=1);

namespace CVeeHub\Test\Integration\Infrastructure\Container\Definition;

use CVeeHub\Test\Contract\AbstractIntegrationTestCase;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;

/**
 * @covers \CVeeHub\Infrastructure\Container\Definition\DoctrineDefinition
 */
class DoctrineDefinitionTest extends AbstractIntegrationTestCase
{
    public function testItDefinesTheEntityManagerInterface()
    {
        $this->assertInstanceOf(EntityManager::class, $this->container->get(EntityManagerInterface::class));
    }
}
