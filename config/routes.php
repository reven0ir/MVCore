<?php
/** @var MVCore\Application $app **/

use MVCore\Middleware\Auth;

const MIDDLEWARE = [
    'auth' => \MVCore\Middleware\Auth::class,
    'guest' => \MVCore\Middleware\Guest::class,
];

$app->router->get('/', [\App\Controllers\HomeController::class, 'index']);

$app->router->get('/about', function () {
    return view('about', ['title' => 'About']);
});

// Post
$app->router->get('/contact', [\App\Controllers\ContactController::class, 'index']);
$app->router->post('/contact', [\App\Controllers\ContactController::class, 'send']);

$app->router->get('/posts/create', [\App\Controllers\PostController::class, 'create'])->only('auth');
$app->router->post('/posts/store', [\App\Controllers\PostController::class, 'store'])->only('auth');

$app->router->get('/posts/edit', [\App\Controllers\PostController::class, 'edit'])->only('auth');
$app->router->post('/posts/update', [\App\Controllers\PostController::class, 'update'])->only('auth');

$app->router->get('/posts/delete', [\App\Controllers\PostController::class, 'delete'])->only('auth');
$app->router->post('/posts/update', [\App\Controllers\PostController::class, 'update'])->only('auth');

$app->router->get('/posts/(?P<slug>[a-z0-9-]+)', [\App\Controllers\PostController::class, 'show']);

// User
$app->router->add('/register', [\App\Controllers\UserController::class, 'register'], ['get', 'post'])->only('guest');
$app->router->add('/login', [\App\Controllers\UserController::class, 'login'], ['get', 'post'])->only('guest');
$app->router->get('/logout', [\App\Controllers\UserController::class, 'logout'])->only('auth');