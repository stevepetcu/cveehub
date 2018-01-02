<?php

namespace CVeeHub\Test\Contract;

use DI\Container;
use PHPUnit\Framework\TestCase;

abstract class AbstractIntegrationTestCase extends TestCase
{
    /** @var  Container */
    protected $container;

    public function setUp()
    {
        parent::setUp();

        $this->container = require PATH_ROOT . '/bootstrap/container.php';
    }

    public function tearDown()
    {
        unset($this->container);

        parent::tearDown();
    }
}
