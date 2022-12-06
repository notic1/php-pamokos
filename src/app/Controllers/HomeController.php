<?php 

namespace App\Controllers;

use App\DB;
use App\Models\User;
use App\View;

class HomeController
{
    public function index()
    {
        $user = new User();
        $user = $user->create('Jhoana doe', 'john@doe.com', password_hash('password', PASSWORD_BCRYPT), 1, 0);   
        
        echo View::make('home/index', ['user' => $user]);
    }
}