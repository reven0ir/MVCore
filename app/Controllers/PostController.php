<?php

namespace App\Controllers;

use App\Models\Post;

class PostController extends BaseController
{

    public function edit()
    {
        $id = request()->get('id');
        $post = db()->findOrFail('posts', $id);
        return view('posts/edit', ['title' => 'Edit post', 'post' => $post]);
    }

    public function update()
    {
        $id = request()->post('id');
        db()->findOrFail('posts', $id);

        $model = new Post();
        $model->loadData();
        $model->attributes['id'] = $id;

        if (!$model->validate()) {
            session()->setFlash('error', $model->listError());
            response()->redirect('/posts/edit?id=' . $id);
        }

        if (false !== $model->update()) {
            session()->setFlash('success', 'Post ' . $id . ' updated');
        } else {
            session()->setFlash('error', 'Error updating post');
        }
        response()->redirect('/posts/edit?id=' . $id);
    }
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

        if ($id = $model->save()) {
            session()->setFlash('success', 'Post ' . $id . ' created');
        } else {
            session()->setFlash('error', 'Unknown error');
        }

        response()->redirect('/posts/create');
    }

    public function delete()
    {
        $id = request()->get('id');
        db()->findOrFail('posts', $id);
        $model = new Post();
        if ($model->delete($id)) {
            session()->setFlash('success', 'Post ' . $id . ' deleted');
        } else {
            session()->setFlash('error', 'Error deleting post');
        }

        response()->redirect('/');
    }
}