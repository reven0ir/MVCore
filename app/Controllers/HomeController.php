<?php

namespace App\Controllers;

use MVCore\Pagination;

class HomeController extends BaseController
{

    public function index()
    {
        $page = request()->get('page', 1);
        $total = db()->count('posts');
        $per_page = 3;
        $pagination = new Pagination((int)$page, $per_page, $total);
        $start = $pagination->getStart();
        $posts = db()->query("SELECT * FROM posts ORDER BY id DESC LIMIT :limit OFFSET :offset", ['limit' => $per_page, 'offset' => $start])->get();

        return view('home', ['title' => 'Home', 'posts' => $posts, 'pagination' => $pagination]);
    }
}
