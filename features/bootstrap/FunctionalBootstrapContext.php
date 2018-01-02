<?php declare(strict_types=1);

use Behat\Behat\Context\Context;
use Psr\Container\ContainerInterface;

class FunctionalBootstrapContext implements Context
{
    /** @var  ContainerInterface */
    protected static $container;

    public function __construct(string $environment, string $constantsPath, string $containerPath)
    {
        putenv('APPLICATION_ENV=' . $environment);

        require $constantsPath;

        static::$container = require $containerPath;
    }

    /**
     * Remove SQLite database file.
     *
     * @AfterSuite
     */
    public static function afterSuite()
    {
        $dbFilePath = static::$container->get('doctrine')['connections']['master']['path'];

        if (file_exists($dbFilePath)) {
            unlink($dbFilePath);
        }
    }
}
