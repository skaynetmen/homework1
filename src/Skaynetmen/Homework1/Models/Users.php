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

    /**
     * Добавление пользователя
     * @param array $fields
     * @return bool
     */
    public function add(array $fields)
    {
        $query = $this->db->prepare("INSERT INTO users (email, name, lastname, password, created_at, updated_at) VALUES (:email, :name, :lastname, :password, :created_at, :updated_at)");

        $query->execute($fields);

        return $this->db->lastInsertId();
    }

    /**
     * Сохранение параметров пользователя
     * @param array $fields
     * @return bool
     */
    public function save(array $fields)
    {
        $sql = "UPDATE users SET email = :email, name = :name, lastname = :lastname, updated_at = :updated_at WHERE id = :id";

        if (!empty($fields[':password'])) {
            $fields[':password'] = password_hash($fields[':password'], PASSWORD_BCRYPT);

            $sql = "UPDATE users SET email = :email, name = :name, lastname = :lastname, password = :password, updated_at = :updated_at WHERE id = :id";
        } else {
            unset($fields[':password']);
        }

        $query = $this->db->prepare($sql);

        return $query->execute($fields);
    }

    /**
     * Удаление пользователя
     * @param int $id
     * @return bool
     */
    public function delete($id)
    {
        $query = $this->db->prepare("DELETE FROM users WHERE id = :id");

        $query->execute([':id' => $id]);

        return $query->rowCount() > 0;
    }
}