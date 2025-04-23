<?php

namespace Core;

/**
 * Class Env
 *
 * Parses .env file and loads environment variables.
 *
 * @package Core
 */
class Env
{
    /**
     * Load environment variables from a .env file.
     *
     * @param string $path
     * @return void
     */
    public static function load(string $path): void
    {
        if (!file_exists($path)) {
            return;
        }

        $lines = file($path, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
        foreach ($lines as $line) {
            if (strpos(trim($line), '#') === 0) {
                continue;
            }

            [$name, $value] = array_map('trim', explode('=', $line, 2));
            if (!array_key_exists($name, $_ENV)) {
                $_ENV[$name] = $value;
                putenv("{$name}={$value}");
            }
        }
    }
}
