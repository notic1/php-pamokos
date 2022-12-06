<?php

namespace App\Models;

class User extends BaseModel
{
    protected array $fields = [
        'name',
        'email',
        'password',
        'is_active',
        'is_admin'
    ];

    protected string $table = 'users';

    public function createWithSpread(...$args)
    {

    }
}
