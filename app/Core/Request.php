<?php

namespace App\Core;

/**
 * Class Request
 *
 * Handles HTTP request data, sanitization, and method checks.
 * Provides methods for retrieving sanitized POST and GET data.
 *
 * @package App\Core
 */
class Request
{
    /**
     * Check if the current request method is POST.
     *
     * @return bool True if the request method is POST, false otherwise.
     */
    public function isPost(): bool
    {
        return $_SERVER['REQUEST_METHOD'] === 'POST';
    }

    /**
     * Check if the current request method is GET.
     *
     * @return bool True if the request method is GET, false otherwise.
     */
    public function isGet(): bool
    {
        return $_SERVER['REQUEST_METHOD'] === 'GET';
    }

    /**
     * Get sanitized POST input value by key.
     *
     * @param string $key The key of the POST variable.
     * @param mixed $default The default value to return if the key does not exist.
     * @return mixed The sanitized POST value, or default if not found.
     */
    public function post(string $key, $default = null)
    {
        return filter_input(INPUT_POST, $key, FILTER_SANITIZE_SPECIAL_CHARS) ?? $default;
    }

    /**
     * Get sanitized GET input value by key.
     *
     * @param string $key The key of the GET variable.
     * @param mixed $default The default value to return if the key does not exist.
     * @return mixed The sanitized GET value, or default if not found.
     */
    public function get(string $key, $default = null)
    {
        return filter_input(INPUT_GET, $key, FILTER_SANITIZE_SPECIAL_CHARS) ?? $default;
    }

    /**
     * Get all sanitized POST data.
     *
     * @return array An associative array of all sanitized POST data.
     */
    public function allPost(): array
    {
        return filter_input_array(INPUT_POST, FILTER_SANITIZE_SPECIAL_CHARS) ?? [];
    }

    /**
     * Get all sanitized GET data.
     *
     * @return array An associative array of all sanitized GET data.
     */
    public function allGet(): array
    {
        return filter_input_array(INPUT_GET, FILTER_SANITIZE_SPECIAL_CHARS) ?? [];
    }
}
