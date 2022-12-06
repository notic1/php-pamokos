<?php

namespace App\Models;

class User extends BaseModel
{
    public function create(
        $name,
        $email,
        $password,
        $is_active = true,
        $is_admin = false
    ) {
        $statement = $this->pdo->prepare(
            'INSERT INTO users (name, email, password, is_active, is_admin) VALUES (?, ?, ?, ?, ?)'
        );
        $statement->execute([$name, $email, $password, $is_active, $is_admin]);
        $id = $this->pdo->lastInsertId();

        return $this->find((int)$id);
    }

    public function find(int $id)
    {
        $fetchStatement = $this->pdo->prepare(
            'SELECT * FROM users WHERE id = ?'
        );
        $fetchStatement->execute([$id]);
     
        return $fetchStatement->fetch();
    }

    public function createWithSpread(...$args)
    {

    }
}
