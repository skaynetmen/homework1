<?php

namespace Skaynetmen\Homework1\Models;

use Skaynetmen\Homework1\Core\Model;

class Works extends Model
{
    private $db;

    public function __construct()
    {
        $config = $this->getDatabaseConfig();

        $this->db = new \PDO("{$config['dbtype']}:dbname={$config['database']};host={$config['host']};charset=utf8",
            $config['user'], $config['password']);
        $this->db->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
    }

    public function get()
    {
        $query = $this->db->query("SELECT * FROM works ORDER BY id DESC");

        return $query->fetchAll(\PDO::FETCH_OBJ);
    }

    public function add($data)
    {
        $data['created_at'] = time();
        $data['updated_at'] = time();

        $query = $this->db->prepare(
            "INSERT INTO works (title, description, link, image, created_at, updated_at) VALUES (:title, :description, :link, :image, :created_at, :updated_at)",
            array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY)
        );

        return $query->execute($data);
    }
}