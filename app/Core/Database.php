<?php

namespace App\Core;

use PDO;
use PDOException;

/**
 * Class Database
 *
 * Singleton class responsible for providing a single PDO database connection instance.
 * Uses environment variables for configuration. Ensures secure, consistent, and efficient
 * database access throughout the application.
 *
 * @package App\Core
 */
class Database
{
    /**
     * Holds the PDO connection instance.
     *
     * @var PDO|null
     */
    private static ?PDO $connection = null;

    /**
     * Private constructor to prevent external instantiation.
     */
    private function __construct()
    {
        // Disallow instantiation
    }

    /**
     * Returns a singleton PDO connection instance.
     *
     * @return PDO
     * @throws PDOException if connection fails
     */
    public static function getInstance(): PDO
    {
        if (self::$connection === null) {
            $host = Env::get('DB_HOST', 'localhost');
            $dbname = Env::get('DB_NAME', 'digify');
            $user = Env::get('DB_USER', 'root');
            $pass = Env::get('DB_PASS', '');

            $dsn = sprintf('mysql:host=%s;dbname=%s;charset=utf8mb4', $host, $dbname);

            try {
                self::$connection = new PDO(
                    $dsn,
                    $user,
                    $pass,
                    [
                        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                        PDO::ATTR_EMULATE_PREPARES => false,
                    ]
                );
            } catch (PDOException $e) {
                // Prefer logging this instead of displaying raw error in production
                http_response_code(500);
                die("Database connection failed. Please try again later.");
            }
        }

        return self::$connection;
    }
}
