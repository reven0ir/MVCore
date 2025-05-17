<?php

namespace MVCore;

class Database
{

    private \PDO $conn;
    private \PDOStatement $stmt;

    public function __construct()
    {
        $dsn = 'pgsql:host='. DB['host'] . ';dbname=' . DB['dbname'];

        try {
            $this->conn = new \PDO($dsn, DB['user'], DB['password'], DB['options']);
        } catch (\PDOException $e) {
            abort($e->getMessage(), 500);
        }

        return $this;
    }

    public function query(string $query, array $params = [])
    {
        try {
            $this->stmt = $this->conn->prepare($query);
            $this->stmt->execute($params);
        } catch (\PDOException $e) {
            abort($e->getMessage(), 500);
        }

        return $this;
    }

    public function get()
    {
        return $this->stmt->fetchAll();
    }

    public function findAll($tbl)
    {
        $this->query("SELECT * FROM {$tbl}");
        return $this->stmt->fetchAll();
    }

    public function findOne($tbl, $id)
    {
        $this->query("SELECT * FROM {$tbl} WHERE id = ? LIMIT 1", [$id]);
        return $this->stmt->fetch();
    }

    public function findOrFail($tbl, $id)
    {
        $result = $this->findOne($tbl, $id);
        if (!$result) {
            abort();
        }

        return $result;
    }
}
