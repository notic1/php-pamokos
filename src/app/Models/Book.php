<?php

namespace App\Models;

use PDO;

class Book extends BaseModel
{
    protected string $table = 'books';

    public function decreaseQuantity()
    {
        $this->update([
            'quantity' => --$this->quantity
        ]);
    }

    public function increaseQuantity()
    {
        $this->update([
            'quantity' => ++$this->quantity
        ]);
    }

    public function getAll(): array
    {
        $statement = $this->pdo->prepare(
            'SELECT *, (SELECT COUNT(ub.user_id) FROM user_books ub WHERE ub.user_id = ? AND b.id = ub.book_id AND deleted_at IS NULL) as book_taken FROM ' . $this->table . ' b'
        );
        
        $statement->execute([User::getUser()->id]);
        
        //Grazinam irasus kaip objektus
        $result = $statement->fetchAll(PDO::FETCH_CLASS, static::class);
        
        return $result;
    }
}