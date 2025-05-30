<?php

use JetBrains\PhpStorm\NoReturn;

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

function response(): \MVCore\Response
{
    return app()->response;
}

function base_url($path = ''): string
{
    return PATH . $path;
}

function h($string): string
{
    return htmlspecialchars($string, ENT_QUOTES);
}

function old($field_name): string
{
    return isset($_POST[$field_name]) ? h($_POST[$field_name]) : '';
}

function get_errors($field_name, $errors = []): string
{
    $output = '';

    if (isset($errors[$field_name])) {
        $output .= '<div class="invalid-feedback d-block"><ul class="list-unstyled"></ul>';
        foreach ($errors[$field_name] as $error) {
            $output .= "<li>{$error}</li>";
        }
        $output .= '</ul></div>';
    }

    return $output;
}

function get_validation_class($field_name, $errors = []): string
{
    if (empty($errors)) {
        return '';
    } else {
        return isset($errors[$field_name]) ? 'is-invalid' : 'is-valid';
    }
}

#[NoReturn] function abort($error = '', $code = 404): void
{
    response()->setResponseCode($code);
    if (DEBUG || $code == 404) {
        echo view("errors/{$code}", ['error' => $error], false);
    }

    die;
}

function db(): \MVCore\Database
{
    return app()->db;
}

function session(): \MVCore\Session
{
    return app()->session;
}

function router(): \MVCore\Router
{
    return app()->router;
}

function get_alerts(): void
{
    foreach (['success', 'error', 'info'] as $type) {
        if ($message = session()->getFlash($type)) {
            $varName = 'flash_' . $type;
            view()->renderPartial("partials/alert_{$type}", [
                $varName => $message
            ]);
        }
    }
}

function get_file_extension($file_name): string
{
    $file_extension = explode('.', $file_name);
    return end($file_extension);
}

function upload_file($file, $index = false) : false|string
{
    $file_extension = (false === $index) ? get_file_extension($file['name']) : get_file_extension($file['name'][$index]);
    $dir = '/' . date("Y") . '/' . date("m") . '/' . date("d");
    if (!is_dir(UPLOADS . $dir)) {
        mkdir(UPLOADS . $dir, 0755, true);
    }
    $file_name = md5(((false === $index) ? $file['name'] : $file['name'][$index]) . time());
    $file_path = UPLOADS . $dir . '/' . $file_name . '.' . $file_extension;
    $file_url = base_url("/uploads{$dir}/{$file_name}.{$file_extension}");
    if (move_uploaded_file((false === $index) ? $file['tmp_name'] : $file['tmp_name'][$index], $file_path)) {
        return $file_url;
    } else {
        error_log('[' . date('Y-m-d H:i:s') . '] Uploading file error: ' . PHP_EOL, 3, ERROR_LOG_FILE);
        return false;
    }
}

function check_auth(): bool
{
    return session()->has('user');
}