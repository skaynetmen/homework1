<?php

namespace Skaynetmen\Homework1\Core;

class Router
{
    private $collection;

    public function __construct(RouteCollection $collection)
    {
        $this->collection = $collection;
    }

    public function run()
    {
        $url = $_SERVER['REQUEST_URI'];

        //Обрезаем параметры
        if (($pos = strpos($url, '?')) !== false) {
            $url = substr($url, 0, $pos);
        }

        return $this->match($url, $_SERVER['REQUEST_METHOD']);
    }

    private function match($url, $method = 'GET')
    {
        foreach ($this->collection->getAll() as $route) {
            //если метод не совпадает, проходим мимо
            if ($method !== $route->getMethod()) {
                continue;
            }

            //проверяем соответсвует ли юрл регулярному выражению указанному в параметрах
            if (!preg_match("@^" . $route->getRegexFilter() . "*$@i", $url, $matches)) {
                continue;
            }

            $params = array();
            //парсим параметры
            if (preg_match_all("/:([\w-%]+)/", $route->getUrl(), $args)) {
                $args = $args[1];
                foreach ($args as $key => $name) {
                    if (isset($matches[$key + 1])) {
                        $params[$name] = $matches[$key + 1];
                    }
                }
            }

            $route->setParams($params);
            $route->handle();

            return $route;
        }

        return false;
    }
}