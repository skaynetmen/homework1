<?php

namespace Skaynetmen\Homework1\Core;


class RouteCollection extends \SplObjectStorage
{
    public function add(Route $route)
    {
        parent::attach($route, null);
    }

    public function getAll() : array
    {
        $collection = [];

        foreach ($this as $route) {
            $collection[] = $route;
        }

        return $collection;
    }
}