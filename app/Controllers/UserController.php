<?php

namespace App\Controllers;

class UserController extends BaseController
{

    public function register()
    {
        if (request()->isPost()) {
            return 'Register POST data';
        }

        return 'Show register form';
    }

}