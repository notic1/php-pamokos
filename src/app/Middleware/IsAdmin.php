<?php

namespace App\Middleware;

use App\Models\User;
use App\Session;

class IsAdmin
{
    public static function handle()
    {
        $user = User::getUser();
        
        if (!$user || !$user->is_admin) {
            Session::sessionMessage('Unauthorized');
            
            return header('Location: /');
        }
    }
}