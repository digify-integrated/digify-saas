<?php

namespace Core;

/**
 * Class Config
 *
 * Loads and retrieves configuration files.
 *
 * @package Core
 */
class Config
{
    /**
     * The loaded configuration values.
     *
     * @var array
     */
    protected static array $configs = [];

    /**
     * Get a configuration value using dot notation.
     *
     * @param string $key
     * @param mixed|null $default
     * @return mixed
     */
    public static function get(string $key, $default = null)
    {
        $segments = explode('.', $key);
        $file = $segments[0];

        if (!isset(self::$configs[$file])) {
            $path = __DIR__ . "/../config/{$file}.php";
            if (file_exists($path)) {
                self::$configs[$file] = require $path;
            } else {
                return $default;
            }
        }

        return self::arrayGet(self::$configs[$file], array_slice($segments, 1), $default);
    }

    /**
     * Helper to retrieve nested array values.
     *
     * @param array $array
     * @param array $keys
     * @param mixed $default
     * @return mixed
     */
    protected static function arrayGet(array $array, array $keys, $default)
    {
        foreach ($keys as $key) {
            if (!is_array($array) || !array_key_exists($key, $array)) {
                return $default;
            }
            $array = $array[$key];
        }
        return $array;
    }
}
