<?php

use Slim\App;

require __DIR__ . '/../bootstrap/constants.php';
require PATH_ROOT . '/vendor/autoload.php';

/** @var App $app */
$app = require PATH_ROOT . '/bootstrap/http_app.php';

$app->run();
