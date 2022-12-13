<?php

namespace App\Middleware;

use App\Models\User;

class IsAdmin
{
    public static function handle()
    {
        $user = User::getUser();

        if (!$user || !$user->is_admin) {
            return header('Location: /');
        }
    }
}