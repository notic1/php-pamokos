<?php 

namespace App\Models;

use App\App;
use App\DB;

abstract class BaseModel
{
    protected DB $pdo;
    protected array $values;

    public function __construct()
    {
        $this->pdo = App::db();
    }

    public function create($arguments) { 
        $this->fields = array_keys($arguments);
        $values = array_values($arguments);
        
        $statement = $this->pdo->prepare(
            'INSERT INTO '. $this->table .' ('. implode(',', $this->fields) .') VALUES ('. $this->fieldsCount() .')'
        );
        
        $statement->execute($values);
        $id = $this->pdo->lastInsertId();

        return $this->find((int)$id);
    }

    public function update($arguments) { 
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

    public function find(int $id)
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
    
    private function fieldsCount()
    {
        $requiredFields = '';

        foreach($this->fields as $key => $field) {
            if (count($this->fields) === $key + 1) {
                $requiredFields .= '?';
            } else {
                $requiredFields .= '?, ';
            }

        }

        return $requiredFields;
    }

    private function prepareUpdateStatement(array $arguments)
    {
        $statement = '';
        foreach ($arguments as $key => $value) {
            $statement .= $key . ' = ? ';
        }

        return $statement;
    }

    public function __get($name)
    {
        return $this->values[$name] ?? null;
    }
}