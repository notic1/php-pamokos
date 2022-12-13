<?php

namespace App\Middleware;

use App\Models\User;

class IsAuthenticated implements Middleware
{
    public static function handle()
    {
        if (!User::authenticated()) {

            return header('Location: /');
        }
    }
}