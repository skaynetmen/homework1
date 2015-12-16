<?php

namespace Skaynetmen\Homework1\Core;


class Url
{
    /**
     * Возвращает текущий URI
     * @return mixed
     */
    public static function get()
    {
        return $_SERVER['REQUEST_URI'];
    }

    /**
     * Возвращает параметры URI в виде массива
     * @return array
     */
    public static function getArgs()
    {
        $args = explode('/', $_SERVER['REQUEST_URI']);

        return array_slice($args, 1);
    }
}