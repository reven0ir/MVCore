<?php

namespace App\Controllers;

class HomeController extends BaseController
{

    public function index()
    {
//        session()->set('name', 'Mykhailo');
//        session()->delete('name');
        $posts = db()->findAll('posts');
        return view('home', ['title' => 'Home', 'posts' => $posts]);
    }
}
