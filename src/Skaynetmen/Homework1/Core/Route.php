<?php

namespace Skaynetmen\Homework1\Core;


class Route
{
    /**
     * URL
     * @var string
     */
    private $url;

    /**
     * Имя контроллера
     * @var string
     */
    private $controller;

    /**
     * Метод на который будет отзываться данный роут
     * @var string
     */
    private $method;

    /**
     * Массив аргументов, которые будут переданы методу контроллера
     * @var array
     */
    private $params = [];

    /**
     * Массив регекспов для параметров URL
     * @var array
     */
    private $filters = [];

    /**
     * Route constructor.
     * @param string $url
     * @param array $config
     */
    public function __construct($url, array $config)
    {
        $methods = ['GET', 'POST', 'PUT', 'DELETE'];

        $this->url = $url;
        $this->controller = $config['controller'];
        $this->method = (isset($config['method']) && in_array($config['method'], $methods))
            ? $config['method'] : 'GET';
        $this->filters = isset($config['filters']) ? (array)$config['filters'] : [];
    }

    /**
     * Возвращает метод роута
     * @return string
     */
    public function getMethod()
    {
        return $this->method;
    }

    /**
     * Возвращает URL роута
     * @return string
     */
    public function getUrl()
    {
        return $this->url;
    }

    /**
     * Возвращает regex фильтр для параметра URL
     * @return mixed
     */
    public function getRegexFilter()
    {
        return preg_replace_callback("/(:\w+)/", array(&$this, 'searchFilter'), $this->url);
    }

    /**
     * Смена параметров передаваемых в метод контроллера
     * @param array $params
     */
    public function setParams(array $params)
    {
        $this->params = $params;
    }

    /**
     * Обработчик роута
     * @throws \Exception
     */
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

    /**
     * Возвращает фильтр для указанного параметра
     * @param array $matches
     * @return string
     */
    private function searchFilter(array $matches)
    {
        if (isset($matches[1]) && isset($this->filters[$matches[1]])) {
            return $this->filters[$matches[1]];
        }

        return "([\w-%]+)";
    }
}