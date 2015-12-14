<?php

namespace Skaynetmen\Homework1\Models;


use Skaynetmen\Homework1\Core\Model;

class Auth extends Model
{
    private $db;

    public function __construct()
    {
        $config = $this->getDatabaseConfig();

        $this->db = new \PDO("{$config['dbtype']}:dbname={$config['database']};host={$config['host']};charset=utf8",
            $config['user'], $config['password']);
        $this->db->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
    }

    public function get($email)
    {
        $query = $this->db->prepare("SELECT password FROM users WHERE active = TRUE AND email = :email");
        $query->execute([':email' => $email]);

        return $query->fetch(\PDO::FETCH_OBJ);
    }
}