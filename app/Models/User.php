<?php

namespace App\Models;

use MVCore\Model;

class User extends Model
{

    protected string $table = 'users';
    protected array $fillable = ['name', 'email', 'password', 'repassword'];
    protected array $rules = [
        'name' => [
            'required' => true,
            'min' => 1,
            'max' => 100,
        ],
        'email' => [
            'email' => true,
            'max' => 100,
            'unique' => 'users,email',
        ],
        'password' => [
            'min' => 6
        ],
        'repassword' => [
            'match' => 'password',
        ],
    ];
    protected array $labels = [
        'name' => 'Name',
        'email' => 'E-mail',
        'password' => 'Password',
        'repassword' => 'Confirm Password',
    ];

    public function auth(): bool
    {
        if (!$user = db()->query("SELECT * FROM {$this->table} WHERE email = ?", [$this->attributes['email']])->getOne()) {
            return false;
        }

        if (!password_verify($this->attributes['password'], $user['password'])) {
            return false;
        }

        $user_data = [];
        foreach($user as $key => $value) {
            if ($key == 'password') {
                continue;
            }
            $user_data[$key] = $value;
        }
        session()->set('user', $user_data);

        return true;
    }

}