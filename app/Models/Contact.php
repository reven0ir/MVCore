<?php

namespace App\Models;

use MVCore\Model;

class Contact extends Model
{
    public array $fillable = ['email', 'content', 'name'];
    public array $rules = [
        'name' => [
            'required' => true,
            'min' => 2,
            'max' => 100
        ],
        'email' => [
            'email' => true,
            'max' => 255
        ],
        'content' => [
            'min' => 25
        ],
        'thumbnail' => [
            'extension' => 'jpg,jpeg,png',
            'size' => 1_048_576, // 1MB
        ],
    ];
    public array $labels = [
        'name' => 'Name',
        'email' => 'E-mail',
        'content' => 'Content',
        'thumbnail' => 'Thumbnail',
    ];
}
