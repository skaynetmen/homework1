<?php

define('ENVIRONMENT', 'dev');

if (defined('ENVIRONMENT')) {
    switch (ENVIRONMENT) {
        case 'dev':
            error_reporting(E_ALL);
            ini_set("display_errors", 1);
            break;

        case 'prod':
            error_reporting(0);
            ini_set("display_errors", 0);
            break;

        default:
            exit('Неверная среда приложения.');
    }
}

if (file_exists('../vendor/autoload.php')) {
    require_once '../vendor/autoload.php';
} else {
    exit('Не найден файл автозагрузки, необходимо выполнить "composer install"');
}

try {
    $collection = new \Skaynetmen\Homework1\Core\RouteCollection();
    $collection->add(new \Skaynetmen\Homework1\Core\Route('/', array(
        'controller' => '\Skaynetmen\Homework1\Controllers\MainController::indexAction',
        'method' => 'GET'
    )));

    $collection->add(new \Skaynetmen\Homework1\Core\Route('/works', array(
        'controller' => '\Skaynetmen\Homework1\Controllers\MainController::worksAction',
        'method' => 'GET'
    )));

    $collection->add(new \Skaynetmen\Homework1\Core\Route('/feedback', array(
        'controller' => '\Skaynetmen\Homework1\Controllers\MainController::feedbackAction',
        'method' => 'GET',
//        'filters' => [':id' => '(\d+)']
    )));

    $collection->add(new \Skaynetmen\Homework1\Core\Route('/works/add', array(
        'controller' => '\Skaynetmen\Homework1\Controllers\MainController::addWorkAction',
        'method' => 'POST'
    )));

    $collection->add(new \Skaynetmen\Homework1\Core\Route('/feedback/send', array(
        'controller' => '\Skaynetmen\Homework1\Controllers\MainController::sendFeedbackAction',
        'method' => 'POST'
    )));

    $collection->add(new \Skaynetmen\Homework1\Core\Route('/auth', array(
        'controller' => '\Skaynetmen\Homework1\Controllers\MainController::authAction',
        'method' => 'GET'
    )));

    $collection->add(new \Skaynetmen\Homework1\Core\Route('/auth/login', array(
        'controller' => '\Skaynetmen\Homework1\Controllers\MainController::loginAction',
        'method' => 'POST'
    )));

    $collection->add(new \Skaynetmen\Homework1\Core\Route('/auth/logout', array(
        'controller' => '\Skaynetmen\Homework1\Controllers\MainController::logoutAction',
        'method' => 'GET'
    )));

    $router = new \Skaynetmen\Homework1\Core\Router($collection);

    if (!$router->run()) {
        throw new \Exception('404 page not found');
    }
} catch (\Exception $e) {
    echo $e->getMessage();
}
