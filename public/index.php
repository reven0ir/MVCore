<?php

$start_time = microtime(true);

if (PHP_MAJOR_VERSION < 8) {
    die('PHP 8.0 or higher is required');
}

require_once __DIR__ . '/../config/init.php';
require_once ROOT . '/vendor/autoload.php';
require_once HELPERS . '/helpers.php';

$app = new \MVCore\Application();
require_once CONFIG . '/routes.php';

$app->run();

if (DEBUG) {
    dump('Time ' . microtime(true) - $start_time);
}