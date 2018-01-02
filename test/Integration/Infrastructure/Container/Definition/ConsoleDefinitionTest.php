<?php declare(strict_types=1);

namespace CVeeHub\Test\Integration\Infrastructure\Container\Definition;

use CVeeHub\Test\Contract\AbstractIntegrationTestCase;
use Symfony\Component\Console\Application;
use Symfony\Component\Console\Helper\HelperSet;

/**
 * @covers \CVeeHub\Infrastructure\Container\Definition\ConsoleDefinition
 */
class ConsoleDefinitionTest extends AbstractIntegrationTestCase
{
    public function testItDefinesTheDoctrineConsoleHelperset()
    {
        $this->assertInstanceOf(HelperSet::class, $this->container->get('doctrine.console.helperset'));
    }

    public function testItDefinesTheConsoleApplication()
    {
        $this->assertInstanceOf(Application::class, $this->container->get(Application::class));
    }
}
