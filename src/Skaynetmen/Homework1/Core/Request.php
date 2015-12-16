<?php

namespace Skaynetmen\Homework1\Core;


class Request
{
    /**
     * Возвращает GET переменную
     * @param string $value
     * @param null $default
     * @return null
     */
    public function get($value, $default = null)
    {
        return isset($_GET[$value]) ? $_GET[$value] : $default;
    }

    /**
     * Возвращает POST переменную
     * @param string $value
     * @param null $default
     * @return null
     */
    public function post($value, $default = null)
    {
        return isset($_POST[$value]) ? $_POST[$value] : $default;
    }

    /**
     * Запрос сделан через ajax
     * @return bool
     */
    public function isAjax()
    {
        return (isset($_SERVER['HTTP_X_REQUESTED_WITH']) &&
            strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest');
    }

    /**
     * Запрос сделан методом GET
     * @return bool
     */
    public function isGet()
    {
        return $this->isMethod('GET');
    }

    /**
     * Проверка соответсвия метода
     * @param string $method
     * @return bool
     */
    private function isMethod($method)
    {
        return isset($_SERVER['REQUEST_METHOD']) && ($_SERVER['REQUEST_METHOD'] === $method);
    }

    /**
     * Запрос сделан методом POST
     * @return bool
     */
    public function isPost()
    {
        return $this->isMethod('POST');
    }

    /**
     * Запрос сделан методом PUT
     * @return bool
     */
    public function isPut()
    {
        return $this->isMethod('PUT');
    }

    /**
     * Запрос сделан методом DELETE
     * @return bool
     */
    public function isDelete()
    {
        return $this->isMethod('DELETE');
    }
}