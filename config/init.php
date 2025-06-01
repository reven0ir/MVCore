<?php

define("ROOT", dirname(__DIR__));

const DEBUG = true;
const ERROR_LOG_FILE = ROOT . '/tmp/error.log';
const WWW = ROOT . '/public';
const UPLOADS = WWW . '/uploads';
const APP = ROOT . '/app';
const CORE = ROOT . '/core';
const HELPERS = ROOT . '/helpers';
const CONFIG = ROOT . '/config';
const VIEWS = APP . '/Views';
const LAYOUT = 'default';
const PATH = 'https://mvcore';
const LOGIN_PAGE = PATH . '/login';
const CACHE = ROOT . '/tmp/cache';
const DB = [
    'host'      =>  'PostgreSQL-17',
    'user'      =>  'revenoir',
    'password'  =>  '',
    'dbname'  =>  'mvcore',
    'charset'   =>  'utf8',
    'options'   =>  [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    ],
];

const EMAIL = [
    'host' => 'sandbox.smtp.mailtrap.io',
    'auth' => true,
    'username' => '5dc446a180c260',
    'password' => 'e166ea360d95b0',
    'secure' => null,
    'port' => 2525,
    'from_email' => 'd9473d2dc4-87bb90@inbox.mailtrap.io',
    'is_html' => true,
    'charset' => 'UTF-8',
    'debug' => 0,
];