<?php

namespace App\Models;

class Book extends BaseModel
{
    protected array $fields = [
        'title',
        'author',
        'year_released',
        'quantity'
    ];

    protected string $table = 'books';
}