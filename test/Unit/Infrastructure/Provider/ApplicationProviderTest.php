<?php declare(strict_types=1);

namespace CVeeHub\Test\Unit\Infrastructure\Provider;

use CVeeHub\Infrastructure\Container\Definition\ApplicationDefinition;
use CVeeHub\Infrastructure\Container\Definition\ConsoleDefinition;
use CVeeHub\Infrastructure\Container\Definition\DatabasePopulatorDefinition;
use CVeeHub\Infrastructure\Container\Definition\DoctrineDefinition;
use CVeeHub\Infrastructure\Container\Definition\ErrorHandlerDefinition;
use CVeeHub\Infrastructure\Container\Definition\RepositoryDefinition;
use CVeeHub\Infrastructure\Provider\ApplicationProvider;
use PHPUnit\Framework\TestCase;

/**
 * @covers \CVeeHub\Infrastructure\Provider\ApplicationProvider
 */
class ApplicationProviderTest extends TestCase
{
    /** @var  array */
    private $definedClasses;

    public function setUp()
    {
        parent::setUp();

        $this->definedClasses = array_map(
            function ($object): string {
                return get_class($object);
            },
            (new ApplicationProvider())->getDefinitions()
        );
    }

    public function assertPreConditions()
    {
        parent::assertPreConditions();

        $this->assertCount(
            7,
            $this->definedClasses,
            "The ApplicationProvider's definitions have changed."
        );
    }

    public function testItProvidesADoctrineDefinition()
    {
        $this->assertContains(DoctrineDefinition::class, $this->definedClasses);
    }

    public function testItProvidesARepositoryDefinition()
    {
        $this->assertContains(RepositoryDefinition::class, $this->definedClasses);
    }

    public function testItProvidesAConsoleDefinition()
    {
        $this->assertContains(ConsoleDefinition::class, $this->definedClasses);
    }

    public function testItProvidesAErrorHandlerDefinition()
    {
        $this->assertContains(ErrorHandlerDefinition::class, $this->definedClasses);
    }

    public function testItProvidesADatabasePopulatorDefinition()
    {
        $this->assertContains(DatabasePopulatorDefinition::class, $this->definedClasses);
    }

    public function testItProvidesAApplicationDefinition()
    {
        $this->assertContains(ApplicationDefinition::class, $this->definedClasses);
    }
}
