<?php

use App\App;
use App\Config\Config;
use App\Controllers\AuthController;
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

// Uzkraunam is .env failo kintamuosius i $_ENV globalu kintamaji
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/..');
$dotenv->load();

// Uzregistrujam routus
$router = new Router;
$router->register('get', '/', [HomeController::class, 'index']);
$router->register('get', '/register', [AuthController::class, 'register']);
$router->register('post', '/register', [AuthController::class, 'store']);
$router->register('get', '/login', [AuthController::class, 'login']);
$router->register('post', '/login', [AuthController::class, 'authenticate']);

//Nustatom kur musu views failai
define('VIEW_PATH', __DIR__ . '/../views/');

session_start();

// Boostrapinam aplikacija /foo/bar
(new App(
    [
        'method' => $_SERVER['REQUEST_METHOD'],
        'uri' => $_SERVER['REQUEST_URI']
    ],
    $router,
    new Config($_ENV)
))->run();