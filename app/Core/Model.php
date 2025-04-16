<?php

namespace App\Core;

use PDO;

/**
 * Class Model
 *
 * Base Model class to be extended by all application-specific models.
 * Provides commonly used database interaction methods using prepared statements.
 *
 * @package App\Core
 */
abstract class Model
{
    /**
     * The PDO database connection instance.
     *
     * @var PDO
     */
    protected PDO $db;

    /**
     * Model constructor.
     * Initializes a PDO connection using the Database singleton.
     */
    public function __construct()
    {
        $this->db = Database::getInstance(); // Fixed incorrect call to non-existent `connection()` method
    }

    /**
     * Execute a raw SQL statement with optional parameters.
     *
     * @param string $sql The SQL query.
     * @param array $params The parameters to bind to the query.
     * @return bool True on success, false on failure.
     */
    protected function query(string $sql, array $params = []): bool
    {
        $stmt = $this->db->prepare($sql);
        return $stmt->execute($params);
    }

    /**
     * Fetch a single row from the database.
     *
     * @param string $sql The SQL query.
     * @param array $params The parameters to bind to the query.
     * @return array|null The result row as an associative array, or null if none.
     */
    protected function fetch(string $sql, array $params = []): ?array
    {
        $stmt = $this->db->prepare($sql);
        $stmt->execute($params);
        $result = $stmt->fetch();
        return $result ?: null;
    }

    /**
     * Fetch all rows from a query.
     *
     * @param string $sql The SQL query.
     * @param array $params The parameters to bind to the query.
     * @return array An array of rows.
     */
    protected function fetchAll(string $sql, array $params = []): array
    {
        $stmt = $this->db->prepare($sql);
        $stmt->execute($params);
        return $stmt->fetchAll();
    }

    /**
     * Get the ID of the last inserted row.
     *
     * @return string The last insert ID.
     */
    protected function lastInsertId(): string
    {
        return $this->db->lastInsertId();
    }
}
