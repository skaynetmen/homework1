<?php

namespace Skaynetmen\Homework1\Core;


class Model
{
    /**
     * Возвращает настройка БД из файла
     * @return array|bool
     * @throws \Exception
     */
    protected function getDatabaseConfig()
    {
        $file = BASEPATH . 'config/database.ini';

        if (file_exists($file)) {
            $ini = parse_ini_file($file, true);

            return [
                'dbtype' => isset($ini['dbtype']) ? $ini['dbtype'] : 'mysql',
                'host' => isset($ini['host']) ? $ini['host'] : '127.0.0.1',
                'database' => isset($ini['database']) ? $ini['database'] : '',
                'user' => isset($ini['user']) ? $ini['user'] : '',
                'password' => isset($ini['password']) ? $ini['password'] : ''
            ];
        } else {
            if (ENVIRONMENT == 'dev') {
                throw new \Exception('Не найден файл настроек database.ini');
            }
        }

        return false;
    }
}