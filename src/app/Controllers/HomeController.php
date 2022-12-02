<?php 

namespace App\Controllers;

use App\DB;
use App\View;

class HomeController
{
    public function index()
    {
        $pdo = (new DB([
            'driver' => $_ENV['DB_DRIVER'],
            'host' => $_ENV['DB_HOST'],
            'database' => $_ENV['DB_DATABASE'],
            'user' => $_ENV['DB_USER'],
            'password' => $_ENV['DB_PASSWORD'],
        ]));
        
        echo View::make('home/index', ['foo' => 'bar']);
    }
}