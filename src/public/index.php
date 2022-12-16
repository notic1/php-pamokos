<?php

use App\App;
use App\Config\Config;
use App\Controllers\AuthController;
use App\Controllers\BookController;
use App\Controllers\HomeController;
use App\Controllers\UserBookController;
use App\Middleware\IsAdmin;
use App\Middleware\IsAuthenticated;
use App\Router;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;

require_once('../vendor/autoload.php');

// $mail = new PHPMailer(true);

// try {
    
//     //Server settings
//     $mail->SMTPDebug = SMTP::DEBUG_OFF;                      //Enable verbose debug output
//     $mail->isSMTP();                                            //Send using SMTP
//     $mail->Host       = 'docker-mail';                     //Set the SMTP server to send through
//     $mail->SMTPAuth   = false;                                   //Enable SMTP authentication
//     // $mail->Username   = 'user@example.com';                     //SMTP username
//     // $mail->Password   = 'secret';                               //SMTP password
//     // $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;            //Enable implicit TLS encryption
//     $mail->Port       = 1025;                                    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`

//     //Recipients
//     $mail->setFrom('from@example.com', 'Mailer');
//     $mail->addAddress('joe@example.net', 'Joe User');     //Add a recipient
//     $mail->addAddress('ellen@example.com');               //Name is optional
//     $mail->addReplyTo('info@example.com', 'Information');
//     $mail->addCC('cc@example.com');
//     $mail->addBCC('bcc@example.com');

//     //Content
//     $mail->isHTML(true);                                  //Set email format to HTML
//     $mail->Subject = 'Here is the subject';
//     $mail->Body    = 'This is the HTML message body <b>in bold!</b>';
//     $mail->AltBody = 'This is the body in plain text for non-HTML mail clients';

//     $mail->send();
//     echo 'Message has been sent';
// } catch (Exception $e) {
//     echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
// }



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
//Home
$router->register('get', '/', [HomeController::class, 'index']);
//Authentication
$router->register(
    'get',
    '/register',
    [AuthController::class, 'register']
);

$router->register(
    'get',
    '/logout',
    [AuthController::class, 'logout'],
    [
        IsAuthenticated::class
    ]
);

$router->register('post', '/register', [AuthController::class, 'store']);
$router->register('get', '/login', [AuthController::class, 'login']);
$router->register('post', '/login', [AuthController::class, 'authenticate']);
//Books resource
$router->register(
    'get',
    '/books',
    [BookController::class, 'index'],
    [
        IsAuthenticated::class
    ]
);
$router->register(
    'get',
    '/books/create',
    [BookController::class, 'create'],
    [
        IsAdmin::class
    ]
);
$router->register(
    'post',
    '/books/create',
    [BookController::class, 'store'],
    [
        IsAdmin::class
    ]
);
$router->register(
    'get',
    '/books/edit',
    [BookController::class, 'edit'],
    [
        IsAdmin::class
    ]
);
$router->register(
    'post',
    '/books/update',
    [BookController::class, 'update'],
    [
        IsAdmin::class
    ]
);
$router->register(
    'post',
    '/books/delete',
    [BookController::class, 'delete'],
    [
        IsAdmin::class
    ]
);

$router->register(
    'post',
    '/books/reserve',
    [UserBookController::class, 'reserve'],
    [IsAuthenticated::class]
);

$router->register(
    'post',
    '/books/return',
    [UserBookController::class, 'return'],
    [IsAuthenticated::class]
);

$router->register(
    'get',
    '/user/books',
    [UserBookController::class, 'index'],
    [IsAuthenticated::class]
);

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
