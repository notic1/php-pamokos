<?php

use App\Controllers\Admin\UserController;
use App\Middleware\IsAdmin;

// Books resource
$router->get('/books/create', [BookController::class, 'create'], [IsAdmin::class]);
$router->post('/books/create', [BookController::class, 'store'], [IsAdmin::class]);
$router->get('/books/edit', [BookController::class, 'edit'], [IsAdmin::class]);
$router->post('/books/update', [BookController::class, 'update'], [IsAdmin::class]);
$router->post('/books/delete', [BookController::class, 'delete'], [IsAdmin::class]);

// User resource
$router->get('/admin/users', [UserController::class, 'index'], [IsAdmin::class]);
$router->get('/admin/users/create', [UserController::class, 'create'], [IsAdmin::class]);
$router->post('/admin/users/create', [UserController::class, 'store'], [IsAdmin::class]);
$router->get('/admin/users/edit', [UserController::class, 'edit'], [IsAdmin::class]);
$router->post('/admin/users/update', [UserController::class, 'update'], [IsAdmin::class]);
$router->post('/admin/users/delete', [UserController::class, 'delete'], [IsAdmin::class]);