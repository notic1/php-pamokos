<?php 

namespace App\Controllers;

use App\DB;
use App\Models\Book;
use App\Models\User;
use App\View;

class HomeController
{
    public function index()
    {
        echo View::make('home/index');
    }
}