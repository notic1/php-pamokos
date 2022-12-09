<?php 

namespace App\Models;

trait PreparesStatements
{
    private function fieldsCount(): string
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

    private function prepareUpdateStatement(array $arguments): string
    {
        $statement = '';
        foreach ($arguments as $key => $value) {
            $statement .= $key . ' = ? ';
        }

        return $statement;
    }
}