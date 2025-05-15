<?php

function app(): \MVCore\Application
{
    return \MVCore\Application::$app;
}

function view($view = '', $data = [], $layout = ''): string | \MVCore\View
{
    if ($view) {
        return app()->view->render($view, $data, $layout);
    } else {
        return app()->view;
    }
}

function request(): \MVCore\Request
{
    return app()->request;
}

function base_url($path = ''): string
{
    return PATH . $path;
}