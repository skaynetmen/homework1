<?php

namespace Skaynetmen\Homework1\Core;


class Controller
{
    /**
     * Редирект
     * @param $url
     * @param bool $permanent
     */
    protected function redirect($url, $permanent = false)
    {
        header('Location: ' . $url, true, $permanent ? 301 : 302);
        exit();
    }

    /**
     * Выводит 404 ошибку
     */
    protected function show404()
    {
        header($_SERVER["SERVER_PROTOCOL"] . ' 404 Not Found');
        echo '404 Not Found';
    }

    /**
     * Выводит 403 ошибку
     */
    protected function show403()
    {
        header($_SERVER["SERVER_PROTOCOL"] . " 403 Unauthorized");
        echo '403 Forbidden';
    }
}