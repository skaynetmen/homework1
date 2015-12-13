<?php

namespace Skaynetmen\Homework1\Core;


class Route
{
    private $url;
    private $controller;
    private $method;
    private $params = [];
    private $filters = [];

    public function __construct($url, array $config)
    {
        $methods = ['GET', 'POST', 'PUT', 'DELETE'];

        $this->url = $url;
        $this->controller = $config['controller'];
        $this->method = (isset($config['method']) && in_array($config['method'], $methods))
            ? $config['method'] : 'GET';
        $this->filters = isset($config['filters']) ? (array)$config['filters'] : [];
    }

    public function getMethod() : string
    {
        return $this->method;
    }

    public function getUrl() : string
    {
        return $this->url;
    }

    public function getRegexFilter()
    {
        return preg_replace_callback("/(:\w+)/", array(&$this, 'searchFilter'), $this->url);
    }

    public function setParams(array $params)
    {
        $this->params = $params;
    }

    public function handle()
    {
        $action = explode('::', $this->controller);

        if (!class_exists($action[0])) {
            throw new \Exception("Не найден класс {$action[0]}");
        } else {
            $instance = new $action[0];
        }

        if (!isset($action[1])) {
            throw new \Exception("Не указан метод, обслуживающий данный URL");
        }

        if (!method_exists($instance, $action[1])) {
            throw new \Exception("Не найден метод {$action[1]} в контроллере {$action[0]}");
        }

        call_user_func_array(array($instance, $action[1]), $this->params);
    }

    private function searchFilter(array $matches) : string
    {
        if (isset($matches[1]) && isset($this->filters[$matches[1]])) {
            return $this->filters[$matches[1]];
        }

        return "([\w-%]+)";
    }
}