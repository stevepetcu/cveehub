<?php declare(strict_types=1);

namespace CVeeHub\Test\Integration\Infrastructure\Container\Definition;

use CVeeHub\Presentation\Action\Error\ErrorAction;
use CVeeHub\Presentation\Action\Error\PageNotFoundAction;
use CVeeHub\Test\Contract\AbstractIntegrationTestCase;

/**
 * @covers \CVeeHub\Infrastructure\Container\Definition\ErrorHandlerDefinition
 */
class ErrorHandlerDefinitionTest extends AbstractIntegrationTestCase
{
    public function testItDefinesTheErrorHandler()
    {
        $this->assertInstanceOf(ErrorAction::class, $this->container->get('errorHandler'));
    }

    public function testItDefinesTheNotFoundHandler()
    {
        $this->assertInstanceOf(PageNotFoundAction::class, $this->container->get('notFoundHandler'));
    }
}
