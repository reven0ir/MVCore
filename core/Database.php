<?php

namespace MVCore;

class Database
{

    protected \PDO $conn;
    protected \PDOStatement $stmt;
    protected array $queries = [];

    public function __construct()
    {
        $dsn = 'pgsql:host=' . DB['host'] . ';dbname=' . DB['dbname'];

        try {
            $this->conn = new \PDO($dsn, DB['user'], DB['password'], DB['options']);
        } catch (\PDOException $e) {
            error_log('[' . date('Y-m-d H:i:s') . '] DB Error: ' . $e->getMessage() . PHP_EOL, 3, ERROR_LOG_FILE);
            abort($e->getMessage(), 500);
        }

        return $this;
    }

    public function query(string $query, array $params = []): static
    {
        try {
            $this->stmt = $this->conn->prepare($query);
            $this->stmt->execute($params);
            if (DEBUG) {
                ob_start();
                $this->stmt->debugDumpParams();
                $this->queries[] = ob_get_clean();
            }
        } catch (\PDOException $e) {
            error_log('[' . date('Y-m-d H:i:s') . '] DB Error: ' . $e->getMessage() . PHP_EOL, 3, ERROR_LOG_FILE);
            abort($e->getMessage(), 500);
        }

        return $this;
    }

    public function get(): array|false
    {
        return $this->stmt->fetchAll();
    }

    public function getOne(): mixed
    {
        return $this->stmt->fetch();
    }

    public function findAll($tbl): array|false
    {
        $this->query("SELECT * FROM {$tbl} ORDER BY id");
        return $this->stmt->fetchAll();
    }

    public function findOne($tbl, $id): mixed
    {
        $this->query("SELECT * FROM {$tbl} WHERE id = ? LIMIT 1", [$id]);
        return $this->stmt->fetch();
    }

    public function findOrFail($tbl, $id): mixed
    {
        $result = $this->findOne($tbl, $id);
        if (!$result) {
            abort();
        }

        return $result;
    }

    public function getInsertId(): false|string
    {
        return $this->conn->lastInsertId();
    }

    public function getRowCount(): int
    {
        return $this->stmt->rowCount();
    }

    public function getColumn(): mixed
    {
        return $this->stmt->fetchColumn();
    }

    public function count($tbl)
    {
        $this->query("SELECT COUNT(*) FROM {$tbl}");
        return $this->getColumn();
    }

    public function getQueries(): array
    {
        $res = [];
        foreach ($this->queries as $key => $query) {
            $line = strtok($query, PHP_EOL);
            while (false !== $line) {
                if (str_contains($line, 'SQL:') || str_contains($line, 'Sent SQL:')) {
                    $res[$key][] = $line;
                }
                $line = strtok(PHP_EOL);
            }
        }
        return $res;
    }
}
