<?php

namespace App;

use App\Config\Config;

class App
{
    private static DB $database;

    public function __construct(
        private array $request,
        private Router $router,
        private Config $config
    ) {
        self::$database = new DB($config->db);
    }

    public function run()
    {
        $this->router->resolve(
            $this->request['uri'],
            $this->request['method']
        );
    }

    public static function db()
    {
        return static::$database;
    }
}
