<?php

namespace App;

use Exception;
use PDO;
use PDOException;

class DB 
{
    private PDO $pdo;

    public function __construct(array $config)
    {
        $defaultOptions = [
            PDO::ATTR_EMULATE_PREPARES => false,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
        ];

        try {
            $this->pdo = new PDO(
                $config['driver']. ':host=' . $config['host'] . ';dbname=' . $config['database'],
                $config['user'],
                $config['password'],
                $defaultOptions
            );
        } catch (Exception $e) {
            throw new PDOException($e->getMessage(), $e->getCode());
        }
    }

    public function __call($methodName, $arguments)
    {
        return call_user_func_array([$this->pdo, $methodName], $arguments);
    }
}