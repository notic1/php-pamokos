<?php

namespace App\Controllers;

use App\Exceptions\RouteNotFoundException;
use App\Mail;
use App\Models\User;
use App\Session;
use App\View;
use Exception;

class AuthController extends Controller
{
    public function register()
    {
        if (User::authenticated()) {
            return header('Location: /');
        }

        echo View::make('auth/register');
    }

    public function login()
    {
        if (User::authenticated()) {
            return header('Location: /');
        }

        echo View::make('auth/login');
    }

    public function authenticate()
    {
        unset($_SESSION['login_error']);

        $email = $_POST['email'];
        $password = $_POST['password'];

        if ($email && $password) {
            $user = new User;
            $user->login($email, $password);
        } else {
            $_SESSION['login_error_message'] = 'Enter user name and password';
            $_SESSION['login_error'] = true;
            return header('Location: /login');
        }
    }

    public function store()
    {
        unset($_SESSION['login_form_errors']);
        $validated = $this->validate(
            $_POST,
            [
                'name' => [
                    'required',
                    'min:6'
                ],
                'email' => [
                    'required',
                    'email'
                ],
                'password' => [
                    'required',
                    'min:6',
                    'confirmed'
                ]
            ]
        );
        if (isset($validated['has_errors']) && $validated['has_errors']) {
            $_SESSION['login_form_errors'] = $validated;

            return header('Location: /register', true, 302);
        }

        $user = new User();
        $user->create($validated);

        $user->setSession();

        return header('Location: /books');
    }

    public function logout()
    {
        User::logout();

        return header('Location: /');
    }

    public function forgotPassword()
    {
        echo View::make('auth/forgot-password');
    }

    public function forgotPasswordPost()
    {
        $user = (new User)->findByValue('email', $_POST['email']);

        if (!$user) {

            throw new RouteNotFoundException();
        }

        $user->generateRememberToken();

        $mailer = new Mail;

        $mailer->sendMail(
            $user->email,
            'Forgot password',
            '
                <p>
                    Reset password <a href="http://localhost/forgot-password/form?token='. $user->forgot_token .'">here </a>
                </p>
            '
        );

        return header('Location: /login');
    }

    public function forgotPasswordForm()
    {
        $user = (new User)->findByValue('forgot_token', $_GET['token']);

        if ($user) {

            echo View::make('auth/password-reset');
            return;
        }

        throw new RouteNotFoundException;
    }

    public function forgotPasswordFormPost()
    {
        $token = $_POST['token'];
        unset($_POST['token']);
        $validated = $this->validate(
            $_POST,
            [
                'password' => [
                    'required',
                    'min:6',
                    'confirmed'
                ]
            ]
        );

        $user = (new User)
            ->findByValue('forgot_token', $token);
        $user->update($validated);
        $user->setSession();
        $user->unsetToken();
        Session::sessionMessage('Password changed', 'success');

        return header('Location: /');
    }
}
