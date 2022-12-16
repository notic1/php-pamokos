<?php

namespace App\Models;

class User extends Authenticatable
{
    protected string $table = 'users';

    public static function isAdmin(): bool
    {
        $user = self::getUser();

        if ($user && $user->is_admin) {

            return true;
        }

        return false;
    }

    public function takenBooks()
    {
        $statement = $this->pdo->prepare(
            'SELECT * FROM user_books LEFT JOIN books ON books.id = user_books.book_id WHERE user_id = ? AND user_books.deleted_at IS NULL'
        );

        $statement->execute([$this->id]);

        return $statement->fetchAll(\PDO::FETCH_CLASS, Book::class);
    }

    public function takeBook(Book $book) 
    {
        $statement = $this->pdo->prepare(
            'INSERT INTO user_books (user_id, book_id) values (?, ?)'
        );

        return $statement->execute([$this->id, $book->id]);
    }

    public function getBook(Book $book) 
    {
        $statement = $this->pdo->prepare(
            'SELECT * FROM user_books LEFT JOIN books ON books.id = user_books.book_id WHERE user_id = ? AND book_id = ? AND deleted_at IS NULL'
        );
        $statement->execute([$this->id, $book->id]);
        $result = $statement->fetch();

        return $result;
    }

    public function returnBook(Book $book): bool
    {
        $this->pdo->beginTransaction();
        try {
            $statement = $this->pdo->prepare(
                'UPDATE user_books SET deleted_at = NOW() WHERE user_id = ? AND book_id = ?'
            );
            $statement->execute([$this->id, $book->id]);
            $book->increaseQuantity();    
        } catch (\Exception $exception) {
            $this->pdo->rollBack();

            return false;
        }
        
        $this->pdo->commit();

        return true;
    }
}
