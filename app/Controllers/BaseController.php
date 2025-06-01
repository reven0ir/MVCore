<?php

namespace App\Controllers;

use MVCore\Controller;

class BaseController extends Controller
{

    public function __construct()
    {
        $users = cache()->get('users');
        if (!$users) {
            $users = db()->findAll('users');
            cache()->set('users', $users, 3600);
        }

        app()->set('users', $users);
    }
}