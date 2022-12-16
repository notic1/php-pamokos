<?php

namespace App\Models;

use App\Session;
use Ramsey\Uuid\Uuid;

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

    public static function getUser(): mixed
    {
        if (self::authenticated()) {
            if (isset(static::$user)) {

                return static::$user;
            }

            $user = new User;
            static::$user = $user->find(str_replace($_ENV['USER_SALT'], '', base64_decode($_COOKIE['user_session'])));

            return static::$user;
        }

        return false;
    }

    public function setSession()
    {
        setcookie('user_session', base64_encode($_ENV['USER_SALT'] . $this->id));
    }

    public function login(
        string $email,
        string $password
    ) {
        $this->findByValue('email', $email);

        if ($this->email && $this->password) {
            if (password_verify($password, $this->password)) {
                $this->setSession();

                return header('Location: /', true, 302);
            }
        }

        Session::sessionMessage('Neteisingi prisijungimo duomenys', 'danger');

        return header('Location: /login', true, 302);
    }

    public static function logout(): void
    {
        setcookie('user_session', '', -1);
        
        session_destroy();
    }

    public function generateRememberToken()
    {
        $uuid = Uuid::uuid1();

        $this->update(
            ['forgot_token' => $uuid->toString()]
        );
    }

    public function unsetToken()
    {
        $this->update(
            ['forgot_token' => NULL]
        );
    }
}
