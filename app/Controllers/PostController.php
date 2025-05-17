<?php

namespace App\Controllers;

use App\Models\Post;

class PostController extends BaseController
{
    public function create()
    {
        return view('posts/create', ['title' => 'Create post']);
    }

    public function store()
    {
        $model = new Post();
        $model->loadData();

        if (!$model->validate()) {
            return view('posts/create', ['title' => 'Create post', 'errors' => $model->getError()]);
        }

        $id = $model->save();
        dump($id);
    }
}