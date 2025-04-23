<?php

namespace Core;

use PDO;
use PDOException;

/**
 * Class Database
 *
 * Manages database connection using PDO.
 *
 * @package Core
 */
class Database
{
    /**
     * The PDO instance.
     *
     * @var PDO|null
     */
    private static ?PDO $connection = null;

    /**
     * Initialize database connection.
     *
     * @return PDO
     */
    public static function connect(): PDO
    {
        if (self::$connection) {
            return self::$connection;
        }

        $driver = $_ENV['DB_CONNECTION'] ?? 'mysql';
        $host = $_ENV['DB_HOST'] ?? '127.0.0.1';
        $port = $_ENV['DB_PORT'] ?? '3306';
        $db = $_ENV['DB_DATABASE'] ?? 'digify_db';
        $user = $_ENV['DB_USERNAME'] ?? 'root';
        $pass = $_ENV['DB_PASSWORD'] ?? '';

        $dsn = "$driver:host=$host;port=$port;dbname=$db;charset=utf8mb4";

        try {
            self::$connection = new PDO($dsn, $user, $pass, [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            ]);
        } catch (PDOException $e) {
            die("Database connection error: " . $e->getMessage());
        }

        return self::$connection;
    }
}
