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
        $book = new Book();
        $book->find(2)->update([
            'quantity' => 99
        ]);

        dump($book);
        echo View::make('home/index', ['book' => $book]);
    }
}