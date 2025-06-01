<?php

namespace App\Controllers;

use App\Models\Contact;
use MVCore\View;

class ContactController extends BaseController
{

    public function index(): View|string
    {
        $title = 'Contact';

        return view('contact', compact('title'));
    }

    public function send()
    {
        $model = new Contact();
        $model->loadData();

        if (isset($_FILES['thumbnail'])) {
            $model->attributes['thumbnail'] = $_FILES['thumbnail'];
        } else {
            $model->attributes['thumbnail'] = [];
        }

        if(!$model->validate()) {
            return view('contact', ['title' => 'Contact form', 'errors' => $model->getError()]);
        }

        $files = [];
        if ($model->attributes['thumbnail']['error'] === 0) {
            $files[] = upload_file($model->attributes['thumbnail'], path: true);
        }

        $content = nl2br($model->attributes['content']);
        $body = "
            <b>Name:</b> {$model->attributes['name']}<br>
            <b>Email:</b> {$model->attributes['email']}<br>
            <b>Content:</b> {$content}<br>
        ";

        if (send_mail([EMAIL['from_email']], 'Mail from MVCore', $body, $files)) {
            session()->setFlash('success', 'Mail sent');
            if ($files) {
                foreach ($files as $file) {
                    unlink($file);
                }
            }
        } else{
            session()->setFlash('error', 'Error sending mail');
        }

        response()->redirect('/contact');
    }

}