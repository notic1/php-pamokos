<?php

use App\App;
use App\Config\Config;
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

$router = new Router;

require_once '../routes/user.php';
require_once '../routes/admin.php';

//sugeneruoti linka paswordo pakeitimui

//routo ir metodo kur sugenruos 

//routo resolvinimo ir metodo 

//tokenas useriu lenteleje

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
