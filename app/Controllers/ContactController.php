<?php

namespace App\Controllers;

use App\Models\Contact;

class ContactController extends BaseController
{

    public function index()
    {
        $title = 'Contact';

        return view('contact', compact('title'));
    }

    public function send()
    {
        $model = new Contact();
        $model->loadData();
        if(!$model->validate()) {
            return view('contact', ['title' => 'Contact form', 'errors' => $model->getError()]);
        }

        response()->redirect('/');
    }

}