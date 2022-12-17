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

    public function getAll($perPage = 50, $page = 1): array
    {   
        $offset = ($page - 1) * $perPage;

        $statement = $this->pdo->prepare(
            'SELECT *, (SELECT COUNT(ub.user_id) FROM user_books ub WHERE ub.user_id = ? AND b.id = ub.book_id AND deleted_at IS NULL) as book_taken FROM ' . $this->table . ' b  LIMIT ? OFFSET ?'
        );
        
        $statement->execute([User::getUser()->id, $perPage, $offset]);
        
        //Grazinam irasus kaip objektus
        $result = $statement->fetchAll(PDO::FETCH_CLASS, static::class);
        
        return $result;
    }

    public function pagesCount($perPage = 50, string $query = null): int
    {
        if ($query) {
            
            $booksCount = $this->pdo->prepare(
                'SELECT count(b.id) as count FROM ' . $this->table . ' b WHERE author LIKE ? OR title LIKE ? OR year_released LIKE ?'
            );
            $booksCount->execute([
                '%' . $query . '%',
                '%' . $query . '%',
                '%' . $query . '%'
            ]);
            
        } else {
            $booksCount = $this->pdo->prepare(
                'SELECT count(b.id) as count FROM ' . $this->table . ' b'
            );
            $booksCount->execute();
        }
        
        $booksCount = $booksCount->fetch()['count'];
        
        return ceil($booksCount / $perPage);    
    }

    public function search(string $query, $page, $perPage = 50)
    {
        $offset = ($page - 1) * $perPage;

        $statement = $this->pdo->prepare(
            'SELECT * FROM ' . $this->table . ' WHERE author LIKE ? OR title LIKE ? OR year_released LIKE ? LIMIT ? OFFSET ?'
        );

        $statement->execute([
            '%' . $query . '%',
            '%' . $query . '%',
            '%' . $query . '%',
            $perPage,
            $offset
        ]);
     
        $result = $statement->fetchAll(PDO::FETCH_CLASS, static::class);
        
        return $result;
    }
}