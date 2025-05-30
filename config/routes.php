<?php
/** @var \MVCore\Application $app **/

$app->router->get('/', [\App\Controllers\HomeController::class, 'index']);

$app->router->get('/about', function () {
    return view('about', ['title' => 'About']);
});

// Post
$app->router->get('/contact', [\App\Controllers\ContactController::class, 'index']);
$app->router->post('/contact', [\App\Controllers\ContactController::class, 'send']);

$app->router->get('/posts/create', [\App\Controllers\PostController::class, 'create']);
$app->router->post('/posts/store', [\App\Controllers\PostController::class, 'store']);

$app->router->get('/posts/edit', [\App\Controllers\PostController::class, 'edit']);
$app->router->post('/posts/update', [\App\Controllers\PostController::class, 'update']);

$app->router->get('/posts/delete', [\App\Controllers\PostController::class, 'delete']);
$app->router->post('/posts/update', [\App\Controllers\PostController::class, 'update']);

$app->router->get('/posts/(?P<slug>[a-z0-9-]+)', [\App\Controllers\PostController::class, 'show']);

// User
$app->router->add('/register', [\App\Controllers\UserController::class, 'register'], ['get', 'post']);