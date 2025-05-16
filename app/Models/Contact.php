<?php

namespace App\Models;

use MVCore\Model;

class Contact extends Model
{
    public array $fillable = ['email', 'content', 'name', 'username'];
    public array $attributes = [];
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
    ];
}
