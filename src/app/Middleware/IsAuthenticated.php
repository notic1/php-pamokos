<?php

namespace App\Middleware;

use App\Models\User;
use App\Session;

class IsAuthenticated implements Middleware
{
    public static function handle()
    {
        if (!User::authenticated()) {
            Session::sessionMessage('Unauthorized', 'danger');
            
            return header('Location: /');
        }
    }
}