<?php

namespace Skaynetmen\Homework1\Models;


use Skaynetmen\Homework1\Core\Model;

class Auth extends Model
{
    /**
     * @var \PDO
     */
    private $db;

    /**
     * Auth constructor.
     */
    public function __construct()
    {
        $config = $this->getDatabaseConfig();

        $this->db = new \PDO("{$config['dbtype']}:dbname={$config['database']};host={$config['host']};charset=utf8",
            $config['user'], $config['password']);
        $this->db->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
    }

    /**
     * Возвращает пароль пользователя
     * @param string $email
     * @return mixed
     */
    public function get($email)
    {
        //на всякий случай почистим поля от html/php тегов
        $email = strip_tags($email);

        $query = $this->db->prepare("SELECT password FROM users WHERE active = TRUE AND email = :email");
        $query->execute([':email' => $email]);

        return $query->fetch(\PDO::FETCH_OBJ);
    }
}