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
        ],
        'thumbnail' => [
            'required' => true,
            'extension' => 'jpg,jpeg,png',
        ]
    ];
    public array $labels = [
        'title' => 'Post title',
        'content' => 'Post content',
        'slug' => 'Slug',
        'thumbnail' => 'Thumbnail',
    ];

}