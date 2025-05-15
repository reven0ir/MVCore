<?php

namespace App\Controllers;

use MVCore\Controller;

class ContactController extends Controller
{

    public function index()
    {
        $title = 'Contact';
        return view('contact', compact('title'));
    }

    public function send()
    {
        dump(request()->getData());
        dump($_POST);
        return 'Contact form POST page';
    }

}