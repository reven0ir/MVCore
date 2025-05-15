<?php
/** @var \MVCore\Application $app **/

$app->router->get('/', function () {
    return view('home', ['title' => 'Home']);
});

$app->router->get('/about', function () {
    return view('about', ['title' => 'About']);
});

$app->router->get('/contact', [\App\Controllers\ContactController::class, 'index']);

$app->router->post('/contact', [\App\Controllers\ContactController::class, 'send']);