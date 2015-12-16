<?php

namespace Skaynetmen\Homework1\Models;

use Skaynetmen\Homework1\Core\Model;

class Works extends Model
{
    /**
     * @var \PDO
     */
    private $db;

    /**
     * Works constructor.
     */
    public function __construct()
    {
        $config = $this->getDatabaseConfig();

        $this->db = new \PDO("{$config['dbtype']}:dbname={$config['database']};host={$config['host']};charset=utf8",
            $config['user'], $config['password']);
        $this->db->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
    }

    /**
     * Возвращает массив работ
     * @return array
     */
    public function get()
    {
        $query = $this->db->query("SELECT * FROM works ORDER BY id DESC");

        return $query->fetchAll(\PDO::FETCH_OBJ);
    }

    /**
     * Добавляет новую работу
     * @param array $data
     * @return bool
     */
    public function add(array $data)
    {
        $data[':created_at'] = time();
        $data[':updated_at'] = time();

        $query = $this->db->prepare(
            "INSERT INTO works (title, description, link, image, created_at, updated_at) VALUES (:title, :description, :link, :image, :created_at, :updated_at)",
            array(\PDO::ATTR_CURSOR => \PDO::CURSOR_FWDONLY)
        );

        $query->execute($data);

        return $this->db->lastInsertId();
    }

    /**
     * Возвращает параметры работы по ID
     * @param int $id
     * @return mixed
     */
    public function getById($id)
    {
        $query = $this->db->prepare("SELECT * FROM works WHERE id = :id");
        $query->execute([':id' => $id]);

        return $query->fetch(\PDO::FETCH_OBJ);
    }

    /**
     * Изменение параметров работы
     * @param array $fields
     * @return bool
     */
    public function save(array $fields)
    {

        $query = $this->db->prepare("UPDATE works SET title = :title, description = :description, image = :image, link = :link, updated_at = :updated_at WHERE id = :id");

        return $query->execute($fields);
    }

    /**
     * Удаление работы
     * @param int $id
     * @return bool
     */
    public function delete($id)
    {
        $query = $this->db->prepare("DELETE FROM works WHERE id = :id");

        $query->execute([':id' => $id]);

        return $query->rowCount() > 0;
    }
}