<?php

namespace App\Core;

/**
 * Class Response
 *
 * Handles HTTP responses, including setting response codes and redirects.
 * Provides methods for managing HTTP response codes and issuing redirects.
 *
 * @package App\Core
 */
class Response
{
    /**
     * Redirect the user to a specified URL.
     *
     * This method sends an HTTP Location header to redirect the user to the given URL
     * and then exits the script to prevent further execution.
     *
     * @param string $url The URL to redirect to.
     * @return void
     */
    public static function redirect(string $url): void
    {
        header("Location: {$url}");
        exit;
    }

    /**
     * Set the HTTP response status code.
     *
     * This method sets the HTTP response code to the given value.
     * Useful for indicating different response states, like 200 for success or 404 for not found.
     *
     * @param int $code The HTTP status code (e.g., 200, 404, 500).
     * @return void
     */
    public static function status(int $code): void
    {
        http_response_code($code);
    }
}
