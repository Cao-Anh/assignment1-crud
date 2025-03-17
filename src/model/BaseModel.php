<?php
declare(strict_types=1);
abstract class BaseModel
{
    protected $pdo;

    public function __construct($pdo)
    {
        $this->pdo = $pdo;
    }

    protected function query($sql, $params = [])
    {
        try {
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute($params);
            return $stmt;
        } catch (PDOException $e) {
            error_log("Database query error: " . $e->getMessage());
            return false;
        }
    }

    protected function select($sql, $params = [])
    {
        $stmt = $this->query($sql, $params);
        return $stmt ? $stmt->fetchAll(PDO::FETCH_ASSOC) : false;
    }

    protected function selectOne($sql, $params = [])
    {
        $stmt = $this->query($sql, $params);
        return $stmt ? $stmt->fetch(PDO::FETCH_ASSOC) : false;
    }

    protected function insert($sql, $params = [])
    {
        $stmt = $this->query($sql, $params);
        return $stmt ? $this->pdo->lastInsertId() : false;
    }

    protected function update($sql, $params = []): bool
    {
        $stmt = $this->query($sql, $params);
        return $stmt ? $stmt->rowCount() > 0 : false;
    }

    protected function delete($sql, $params = []): bool
    {
        $stmt = $this->query($sql, $params);
        return $stmt ? $stmt->rowCount() > 0 : false;
    }
}