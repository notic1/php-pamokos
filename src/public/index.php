<?php

use App\App;
use App\Config\Config;
use App\Controllers\HomeController;
use App\Router;

require_once('../vendor/autoload.php');

// Library managment system
//Duomenu bazes

/** 
 * books: id, title, author, year_released, quantity
 * user: id, name, email, password, is_active, is_admin
 * user_books: user_id, book_id, created_at, deleted_at  
 * DONE
 */

/**
 * Routes: booklist, userbooks, users, register, login, takebook, returnbook
 */

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/..');
$dotenv->load();

$router = new Router;

$router->register('get', '/', [HomeController::class, 'index']);

define('VIEW_PATH', __DIR__ . '/../views/');


(new App(
    [
        'method' => $_SERVER['REQUEST_METHOD'],
        'uri' => $_SERVER['REQUEST_URI']
    ],
    $router,
    new Config($_ENV)
))->run();