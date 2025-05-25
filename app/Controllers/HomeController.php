<?php

namespace App\Controllers;

class HomeController extends BaseController
{

    public function index()
    {
        $posts = db()->findAll('posts');
        return view('home', ['title' => 'Home', 'posts' => $posts]);
    }
}
