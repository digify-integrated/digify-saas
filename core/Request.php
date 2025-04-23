<?php

namespace Core;

/**
 * Class Request
 *
 * Encapsulates HTTP request data and provides helper methods
 * to retrieve and sanitize input.
 *
 * @package Core
 */
class Request
{
    /**
     * Get a value from $_GET or return default.
     *
     * @param string $key
     * @param mixed|null $default
     * @return mixed
     */
    public function get(string $key, $default = null)
    {
        return $_GET[$key] ?? $default;
    }

    /**
     * Get a value from $_POST or return default.
     *
     * @param string $key
     * @param mixed|null $default
     * @return mixed
     */
    public function post(string $key, $default = null)
    {
        return $_POST[$key] ?? $default;
    }

    /**
     * Get the request method (GET, POST, etc.)
     *
     * @return string
     */
    public function method(): string
    {
        return $_SERVER['REQUEST_METHOD'];
    }

    /**
     * Get the full request URI.
     *
     * @return string
     */
    public function uri(): string
    {
        return parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
    }

    /**
     * Determine if the request method matches.
     *
     * @param string $method
     * @return bool
     */
    public function isMethod(string $method): bool
    {
        return strtoupper($method) === $this->method();
    }
}
