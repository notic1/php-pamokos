<?php

namespace App;

class Session
{

    public static function setSession(string $key, mixed $value): void
    {

    }

    public static function getSession(string $key): void
    {

    }

    public static function sessionMessage(string $message, string $type = 'danger'): void
    {
        $_SESSION['success_message'] = [
            'message' => $message,
            'shown' => false,
            'type' => $type
        ];
    }

}