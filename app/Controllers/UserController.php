<?php

namespace App\Controllers;

use App\Models\User;
use MVCore\View;

class UserController extends BaseController
{

    public function register(): View|string
    {
        if (request()->isPost()) {
            $model = new User();
            $model->loadData();
            if (!$model->validate()) {
                return view('users/register', ['title' => 'Sign Up', 'errors' => $model->getError()]);
            }

            $model->attributes['password'] = password_hash($model->attributes['password'], PASSWORD_DEFAULT);
            unset($model->attributes['repassword']);
            if ($model->save()) {
                session()->setFlash('success', 'Successfully registered.');
                response()->redirect(LOGIN_PAGE);
            } else {
                session()->setFlash('error', 'Error registering.');
            }
        }

        return view('users/register', ['title' => 'Sign Up']);
    }

    public function login(): View|string
    {
        if (request()->isPost()) {
            $model = new User();
            $model->loadData();
            if (!$model->validate($model->attributes, [
                'email' => ['required' => true],
                'password' => ['required' => true],
            ])) {
                return view('users/login', ['title' => 'Sign In', 'errors' => $model->getError()]);
            }

            if ($model->auth()) {
                session()->setFlash('success', 'Successfully logged.');
                response()->redirect('/');
            } else {
                session()->setFlash('error', 'Incorrect email or password.');
                response()->redirect(LOGIN_PAGE);
            }
        }

        return view('users/login', ['title' => 'Sign In']);
    }

    public function logout(): void
    {
        if (check_auth()) {
            session()->delete('user');
        }
        response()->redirect('/');
    }

}