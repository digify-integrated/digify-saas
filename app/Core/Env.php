<?php

namespace App\Core;

/**
 * Class Env
 *
 * Loads and retrieves environment variables from a .env file into the $_ENV superglobal.
 * Provides methods to read environment variables and retrieve their values.
 *
 * @package App\Core
 */
class Env
{
    /**
     * Load environment variables from a specified .env file into the $_ENV superglobal.
     *
     * @param string $filePath The path to the .env file. Defaults to the project root directory.
     * @throws \Exception If the .env file is not found or cannot be loaded.
     */
    public static function load(string $filePath = __DIR__ . '/../../.env'): void
    {
        if (!file_exists($filePath)) {
            throw new \Exception(".env file not found at: {$filePath}");
        }

        $lines = file($filePath, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);

        foreach ($lines as $line) {
            // Skip comments and empty lines
            if (str_starts_with(trim($line), '#')) {
                continue;
            }

            // Split the line into key and value
            [$key, $value] = array_map('trim', explode('=', $line, 2));

            // Set the environment variable if it's not already set
            if (!array_key_exists($key, $_ENV)) {
                $_ENV[$key] = $value;
            }
        }
    }

    /**
     * Retrieve an environment variable value from $_ENV with an optional fallback.
     *
     * @param string $key The environment variable key.
     * @param mixed $default The default value to return if the key does not exist.
     * @return mixed The value of the environment variable, or the default if not found.
     */
    public static function get(string $key, $default = null)
    {
        return $_ENV[$key] ?? $default;
    }
}
