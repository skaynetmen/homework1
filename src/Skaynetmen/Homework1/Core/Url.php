<?php

namespace Skaynetmen\Homework1\Core;


class Url
{
    public static function get()
    {
        return $_SERVER['REQUEST_URI'];
    }

    public static function getArgs()
    {
        $args = explode('/', $_SERVER['REQUEST_URI']);

        return array_slice($args, 1);
    }
}