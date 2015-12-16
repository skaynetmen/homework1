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
}