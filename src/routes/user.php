<?php

use App\Controllers\AuthController;
use App\Controllers\BookController;
use App\Controllers\HomeController;
use App\Controllers\UserBookController;
use App\Middleware\IsAdmin;
use App\Middleware\IsAuthenticated;

$router->get('/', [HomeController::class, 'index']);
//Authentication
$router->get('/register', [AuthController::class, 'register']);
$router->get('/logout', [AuthController::class, 'logout'], [IsAuthenticated::class]);
$router->post('/register', [AuthController::class, 'store']);
$router->get('/login', [AuthController::class, 'login']);
$router->post('/login', [AuthController::class, 'authenticate']);
//Books resource
$router->get('/books', [BookController::class, 'index'], [IsAuthenticated::class]);
$router->post('/books/reserve', [UserBookController::class, 'reserve'], [IsAuthenticated::class]);
$router->post('/books/return', [UserBookController::class, 'return'], [IsAuthenticated::class]);
$router->get('/user/books', [UserBookController::class, 'index'], [IsAuthenticated::class]);

$router->get('/forgot-password', [AuthController::class, 'forgotPassword']);
$router->post('/forgot-password', [AuthController::class, 'forgotPasswordPost']);

$router->get('/forgot-password/form', [AuthController::class, 'forgotPasswordForm']);
$router->post('/forgot-password/form', [AuthController::class, 'forgotPasswordFormPost']);
