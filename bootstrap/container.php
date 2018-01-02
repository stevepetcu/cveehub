<?php

use CVeeHub\Infrastructure\Factory\Bootstrap\ConfigurationFactory;
use CVeeHub\Infrastructure\Factory\Bootstrap\ContainerFactory;

$environment = getenv('APPLICATION_ENV') ?: 'production';

$configurationPaths = [
    PATH_CONFIG . '/common',
    PATH_CONFIG . "/$environment",
];

$configurationFactory = new ConfigurationFactory($configurationPaths);

$configuration = $configurationFactory->create();
$providers = require PATH_CONFIG . '/providers.php';

$containerFactory = new ContainerFactory($configuration, $providers);

return $containerFactory->create();
