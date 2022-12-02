<?php

use App\DB;
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

$router->register('get', '/', [App\Controllers\HomeController::class, 'index']);
$router->register('get', '/foo', function() {
    echo 'Testas';
});

define('VIEW_PATH', __DIR__ . '/../views/');

$router->resolve(
    method: $_SERVER['REQUEST_METHOD'],
    uri: $_SERVER['REQUEST_URI']
);