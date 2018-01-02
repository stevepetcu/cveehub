<?php

namespace CVeeHub\Test\Contract;

use Symfony\Component\Console\Application;
use Symfony\Component\Console\Input\ArrayInput;
use Symfony\Component\Console\Output\NullOutput;

abstract class AbstractDatabaseIntegrationTestCase extends AbstractIntegrationTestCase
{
    /** @var  Application */
    private $application;

    public function setUp()
    {
        parent::setUp();

        $this->application = $this->container->get(Application::class);

        $input = new ArrayInput([
                'command' => 'orm:schema-tool:create',
            ]
        );

        $output = new NullOutput();

        // We want to display any exceptions which may occur during database bootstrapping.
        $this->application->setCatchExceptions(false);

        // Set auto exit to false, otherwise all execution will stop after the command is finished running.
        $this->application->setAutoExit(false);

        $this->application->run($input, $output);
    }

    public function tearDown()
    {
        $input = new ArrayInput([
                'command' => 'orm:schema-tool:drop',
                '--force' => true
            ]
        );

        $output = new NullOutput();

        $this->application->run($input, $output);

        parent::tearDown();
    }

    /**
     * Make sure that we start with a clean slate.
     */
    public static function setUpBeforeClass()
    {
        parent::setUpBeforeClass();

        static::unlinkDatabaseFile();
    }

    /**
     * If someone could explain me why creating an in-memory SQLite database with a shared cache
     * creates an actual file on the disk, send me an email. For what it's worth,
     * the database is still only shared in the process that created it.
     */
    public static function tearDownAfterClass()
    {
        static::unlinkDatabaseFile();

        parent::tearDownAfterClass();
    }

    private static function unlinkDatabaseFile()
    {
        if (file_exists(PATH_ROOT . '/:memory:?cache=cveehub')) {
            unlink(PATH_ROOT . '/:memory:?cache=cveehub');
        }
    }
}
