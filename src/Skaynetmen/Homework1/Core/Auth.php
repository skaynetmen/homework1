<?php

namespace Skaynetmen\Homework1\Core;


class Auth
{

    public static function login($user)
    {
        if (!self::loggedIn()) {
            @session_start();
            $_SESSION['loggedIn'] = true;
            $_SESSION['user'] = $user;
            session_write_close();

            return true;
        }

        return false;
    }

    public static function loggedIn()
    {
        @session_start();
        session_write_close();

        return isset($_SESSION['loggedIn']) ? $_SESSION['loggedIn'] : false;
    }

    public static function logout()
    {
        @session_start();

        return session_destroy();
    }

    public static function getUser()
    {
        return (self::loggedIn()) ? $_SESSION['user'] : false;
    }
}