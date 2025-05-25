<?php

namespace App\Models;

use MVCore\Model;

class Post extends Model
{

    public string $table = 'posts';

    public array $fillable = ['title', 'content', 'slug'];
    public array $rules = [
        'title' => [
            'required' => true,
        ],
        'content' => [
            'required' => true,
        ],
        'slug' => [
            'required' => true,
            'unique' => 'posts,slug',
        ]
    ];
    public array $labels = [
        'title' => 'Post title',
        'content' => 'Post content',
        'slug' => 'Slug',
    ];

}