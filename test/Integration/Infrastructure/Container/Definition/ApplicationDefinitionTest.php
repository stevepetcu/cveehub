<?php declare(strict_types=1);

namespace CVeeHub\Test\Integration\Infrastructure\Container\Definition;

use CVeeHub\Test\Contract\AbstractIntegrationTestCase;
use Slim\App;

/**
 * @covers \CVeeHub\Infrastructure\Container\Definition\ApplicationDefinition
 */
class ApplicationDefinitionTest extends AbstractIntegrationTestCase
{
    public function testItDefinesTheApp()
    {
        $this->assertInstanceOf(App::class, $this->container->get(App::class));
    }
}
