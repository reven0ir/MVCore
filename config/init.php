<?php

define("ROOT", dirname(__DIR__));

const DEBUG = true;
const WWW = ROOT . '/public';
const APP = ROOT . '/app';
const CORE = ROOT . '/core';
const HELPERS = ROOT . '/helpers';
const CONFIG = ROOT . '/config';
const VIEWS = APP . '/Views';
const LAYOUT = 'default';
const PATH = 'http://localhost';
const DB = [
    'host'      =>  'localhost',
    'user'      =>  'revenoir',
    'password'  =>  '',
    'dbname'  =>  'mvcore',
    'charset'   =>  'utf8',
    'options'   =>  [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    ],
];