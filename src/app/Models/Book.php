<?php

namespace App\Models;

class Book extends BaseModel
{
    protected string $table = 'books';

    public function decreaseQuantity()
    {
        $this->update([
            'quantity' => --$this->quantity
        ]);
    }
}