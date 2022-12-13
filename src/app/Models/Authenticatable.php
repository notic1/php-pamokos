<?php

namespace App\Models;

class Authenticatable extends BaseModel
{
    public static self $user;

    public static function authenticated()
    {
        if (isset($_COOKIE['user_session'])) {

            return str_replace($_ENV['USER_SALT'], '', base64_decode($_COOKIE['user_session'])) ? true : false;
        }

        return false;
    }

    public static function getUser()
    {
        if (self::authenticated()) {
            if (isset(static::$user)) {
    
                return static::$user;
            }
    
            $user = new self;
            static::$user = $user->find(str_replace($_ENV['USER_SALT'], '', base64_decode($_COOKIE['user_session'])));
        }
    }

    public function setSession()
    {
        setcookie('user_session', base64_encode($_ENV['USER_SALT'] . $this->id));
    }

    public function login(
        string $email,
        string $password
    )
    {
        $this->findByValue('email', $email);

        if (password_verify($password, $this->password)) {
            $this->setSession();

            return header('Location: /', true, 302);
        }

        $_SESSION['login_error'] = true;

        return header('Location: /login', true, 302);
    }
}