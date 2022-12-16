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
        
        if (isset($_SESSION['success_message']) && $_SESSION['success_message']['shown']) {
            self::clearSessionMessages();
        } else if (isset($_SESSION['success_message']) && !$_SESSION['success_message']['shown']) {
            $_SESSION['success_message']['shown'] = true;
        }
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

    public static function clearSessionMessages()
    {
        unset($_SESSION['success_message']);
    }
}
