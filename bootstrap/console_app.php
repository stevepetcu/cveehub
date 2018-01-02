<?php

use Psr\Container\ContainerInterface;
use Symfony\Component\Console\Application;

/** @var ContainerInterface $container */
$container = require PATH_ROOT . '/bootstrap/container.php';
$console = $container->get(Application::class);

$commands = [
    // add commands here.
];

$console->addCommands($commands);

return $console;
