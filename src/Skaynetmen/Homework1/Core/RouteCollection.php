<?php

namespace Skaynetmen\Homework1\Core;


class RouteCollection extends \SplObjectStorage
{
    /**
     * Добавляем роут в хранилище
     * @param Route $route
     */
    public function add(Route $route)
    {
        parent::attach($route, null);
    }

    /**
     * Возвращаем массив всех роутов из хранилища
     * @return mixed
     */
    public function getAll() : array
    {
        $collection = [];

        foreach ($this as $route) {
            $collection[] = $route;
        }

        return $collection;
    }
}