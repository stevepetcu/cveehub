<?php

use DI\Container;
use Slim\App;

/** @var Container $container */
$container = require __DIR__ . '/container.php';

/** @var App $app */
$app = $container->get(App::class);

require PATH_CONFIG . '/middleware.php';
require PATH_CONFIG . '/routes.php';

return $app;
