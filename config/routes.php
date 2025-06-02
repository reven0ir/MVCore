<?php
/** @var MVCore\Application $app **/

use MVCore\Middleware\Auth;

const MIDDLEWARE = [
    'auth' => \MVCore\Middleware\Auth::class,
    'guest' => \MVCore\Middleware\Guest::class,
];

$app->router->get('/', [\App\Controllers\HomeController::class, 'index']);
