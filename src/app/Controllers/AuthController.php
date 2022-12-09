<?php

namespace App\Controllers;

use App\Models\User;
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
        $email = $_POST['email'];
        $password = $_POST['password'];

        $user = new User;
        $user->login($email, $password);
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
    }
}
