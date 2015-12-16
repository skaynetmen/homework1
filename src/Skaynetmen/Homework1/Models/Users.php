<?php

namespace Skaynetmen\Homework1\Models;


use Skaynetmen\Homework1\Core\Model;

class Users extends Model
{
    /**
     * @var \PDO
     */
    private $db;

    /**
     * Users constructor.
     */
    public function __construct()
    {
        $config = $this->getDatabaseConfig();

        $this->db = new \PDO("{$config['dbtype']}:dbname={$config['database']};host={$config['host']};charset=utf8",
            $config['user'], $config['password']);
        $this->db->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
    }

    /**
     * Возвращает массив пользователей
     * @return array
     */
    public function get()
    {
        $query = $this->db->query("SELECT * FROM users WHERE active = TRUE ORDER BY id DESC");

        return $query->fetchAll(\PDO::FETCH_OBJ);
    }

    /**
     * Возвращает параметры работы по ID
     * @param int $id
     * @return mixed
     */
    public function getById($id)
    {
        $query = $this->db->prepare("SELECT * FROM users WHERE id = :id");
        $query->execute([':id' => $id]);

        return $query->fetch(\PDO::FETCH_OBJ);
    }
}