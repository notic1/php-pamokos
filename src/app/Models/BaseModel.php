<?php 

namespace App\Models;

use App\App;
use App\DB;
use PDOException;

abstract class BaseModel implements ModelInterface
{
    use PreparesStatements;

    protected DB $pdo;
    protected array $values;

    public function __construct()
    {
        $this->pdo = App::db();
    }

    public function create(array $arguments): self
    { 
        $this->fields = array_keys($arguments);
        $values = array_values($arguments);
        
        $statement = $this->pdo->prepare(
            'INSERT INTO '. $this->table .' ('. implode(',', $this->fields) .') VALUES ('. $this->fieldsCount() .')'
        );
        
        $statement->execute($values);
        $id = $this->pdo->lastInsertId();

        return $this->find((int)$id);
    }

    public function update(array $arguments): self
    { 
        $this->fields = array_keys($arguments);
        $values = array_values($arguments);
        array_push($values, $this->id);
        
        $statement = $this->pdo->prepare(
            'UPDATE '. $this->table .' SET '. $this->prepareUpdateStatement($arguments) . 'WHERE id = ?'
        );
        
        $statement->execute($values);
        $this->values = array_merge($this->values, $arguments);

        return $this;
    }

    public function find(int $id): self
    {
        $fetchStatement = $this->pdo->prepare(
            'SELECT * FROM '. $this->table .' WHERE id = ?'
        );
        $fetchStatement->execute([$id]);
        $result = $fetchStatement->fetch();

        if (!$result) {
            throw new \Exception('Irasas nerastas');
        }

        $this->values = $result;

        return $this;
    }

    public function delete(): bool
    {
        try {
            $statement = $this->pdo->prepare(
                'DELETE FROM ' . $this->table . ' WHERE id = ?'
            );
    
            $statement->execute([$this->id]);
        } catch (PDOException $exception) {

            return false;
        }

        return true;
    }

    public function findByValue(string $key, string $value): void
    {
        $statement = $this->pdo->prepare(
            'SELECT * FROM ' . $this->table . ' WHERE ' . $key . ' = ?'
        );

        $statement->execute([$value]);
        $result = $statement->fetch();

        if (!$result) {
            throw new \Exception('Irasas nerastas');
        }

        $this->values = $result;
    }

    public function __get($name): mixed
    {
        return $this->values[$name] ?? null;
    }
}