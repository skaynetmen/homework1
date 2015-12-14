<?php

namespace Skaynetmen\Homework1\Core;


class View
{
    /**
     * Шаблон
     * @var string
     */
    private $template;

    /**
     * Часть
     * @var string
     */
    private $partial;

    /**
     * View constructor.
     */
    public function __construct()
    {
        //Выставляем по-дефолту основным шаблоном файл index.phtml
        $this->setTemplate('index.phtml');
    }

    /**
     * Задает имя шаблона
     * @param string $value
     * @throws \Exception
     */
    public function setTemplate($value)
    {
        if (!file_exists(BASEPATH . "views/{$value}")) {
            throw new \Exception("Не найден файл шаблона {$value}");
        } else {
            $this->template = $value;
        }
    }

    /**
     * Статичная подгрузка части
     * @param string $value
     */
    public static function includePartial($value)
    {
        include BASEPATH . "views/{$value}";
    }

    /**
     * Возвращает содержимое объявленной части
     */
    public function getPartial()
    {
        include BASEPATH . "views/{$this->partial}";
    }

    /**
     * Здает имя части
     * @param string $value
     * @throws \Exception
     */
    public function setPartial($value)
    {
        if (!file_exists(BASEPATH . "views/{$value}")) {
            throw new \Exception("Не найдена часть шаблона {$value}");
        } else {
            $this->partial = $value;
        }
    }

    /**
     * Рендерит страницу
     * @param mixed $data
     * @throws \Exception
     */
    public function render($data = array())
    {
        if (!$this->partial) {
            throw new \Exception("Не задана часть шаблона");
        }

        $data = is_object($data) ? get_object_vars($data) : $data;

        if (is_array($data)) {
            extract($data);
        }

        //чтобы распакованные переменные были доступны в шаблоне, используем include
        include BASEPATH . "views/" . $this->template;
    }

    /**
     * Подгрузка части
     * @param $value
     */
    public function requirePartial($value)
    {
        include BASEPATH . "views/{$value}";
    }
}