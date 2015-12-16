<?php

namespace Skaynetmen\Homework1\Core;


class Auth
{
    /**
     * Авторизация пользователя
     * @param $user
     * @return bool
     */
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

    /**
     * Авторизован ли пользователь
     * @return bool
     */
    public static function loggedIn()
    {
        @session_start();
        session_write_close();

        return isset($_SESSION['loggedIn']) ? $_SESSION['loggedIn'] : false;
    }

    /**
     * Выход пользователя
     * @return bool
     */
    public static function logout()
    {
        @session_start();

        return session_destroy();
    }

    /**
     * Возвращает имя пользователя
     * @return bool
     */
    public static function getUser()
    {
        return (self::loggedIn()) ? $_SESSION['user'] : false;
    }
}