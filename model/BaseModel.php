<?php
declare(strict_types=1);
abstract class BaseModel
{
    protected $pdo;

    public function __construct($pdo)
    {
        $this->pdo = $pdo;
    }

    /**
     * Execute a query with optional parameters.
     *
     * @param string $sql The SQL query.
     * @param array $params Parameters to bind in the query.
     * @return PDOStatement|false The result set or false on failure.
     */
    protected function query($sql, $params = []):bool
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

    /**
     * Fetch multiple records.
     *
     * @param string $sql The SQL query.
     * @param array $params Query parameters.
     * @return array Result set.
     */
    protected function select($sql, $params = []):array
    {
        $stmt = $this->query($sql, $params);
        return $stmt ? $stmt->fetchAll(PDO::FETCH_ASSOC) : [];
    }

    /**
     * Fetch a single record.
     *
     * @param string $sql The SQL query.
     * @param array $params Query parameters.
     * @return array|false A single record or false if not found.
     */
    protected function selectOne($sql, $params = []):array
    {
        $stmt = $this->query($sql, $params);
        return $stmt ? $stmt->fetch(PDO::FETCH_ASSOC) : false;
    }

    /**
     * Insert data into the database.
     *
     * @param string $sql The INSERT SQL query.
     * @param array $params Query parameters.
     * @return int|false The last inserted ID or false on failure.
     */
    protected function insert($sql, $params = []):array
    {
        $stmt = $this->query($sql, $params);
        return $stmt ? $this->pdo->lastInsertId() : false;
    }

    /**
     * Update records in the database.
     *
     * @param string $sql The UPDATE SQL query.
     * @param array $params Query parameters.
     * @return bool True on success, false on failure.
     */
    protected function update($sql, $params = []):bool
    {
        $stmt = $this->query($sql, $params);
        return $stmt ? $stmt->rowCount() > 0 : false;
    }

    /**
     * Delete records from the database.
     *
     * @param string $sql The DELETE SQL query.
     * @param array $params Query parameters.
     * @return bool True on success, false on failure.
     */
    protected function delete($sql, $params = []):bool
    {
        $stmt = $this->query($sql, $params);
        return $stmt ? $stmt->rowCount() > 0 : false;
    }
}
