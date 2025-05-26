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
            'file' => true,
            'extension' => 'jpg,jpeg,png',
            'size' => 1_048_576, // 1MB
        ],
        'gallery' => [
            'extension' => 'jpg,jpeg,png',
            'size' => 1_048_576, // 1MB
        ]
    ];
    public array $labels = [
        'title' => 'Post title',
        'content' => 'Post content',
        'slug' => 'Slug',
        'thumbnail' => 'Thumbnail',
        'gallery' => 'Gallery',
    ];

    public function savePost(): false|string
    {
        $thumbnail = $this->attributes['thumbnail']['name'] ? $this->attributes['thumbnail'] : null;
        unset($this->attributes['thumbnail']);

        $gallery = $this->attributes['gallery']['name'][0] ? $this->attributes['gallery'] : null;
        unset($this->attributes['gallery']);

        $id = $this->save();

        if ($thumbnail) {
            if ($file_url = upload_file($thumbnail)) {
                db()->query("UPDATE posts SET thumbnail = ? WHERE id = ?", [$file_url, $id]);
            }
        }

        // TODO: optimize the query
        if ($gallery) {
            for ($i = 0; $i < count($gallery['name']); $i++) {
                if ($file_url = upload_file($gallery, $i)) {
                    db()->query("INSERT INTO gallery (post_id, image) VALUES (?, ?)", [$id, $file_url]);
                }
            }
        }

        return $id;
    }

}