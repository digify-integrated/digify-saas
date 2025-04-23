<?php

namespace Core;

/**
 * Class Session
 *
 * Basic session handler.
 *
 * @package Core
 */
class Session
{
    /**
     * Start the session if not started.
     */
    public static function start(): void
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
    }

    /**
     * Set a session variable.
     *
     * @param string $key
     * @param mixed $value
     */
    public static function set(string $key, $value): void
    {
        $_SESSION[$key] = $value;
    }

    /**
     * Get a session variable.
     *
     * @param string $key
     * @param mixed|null $default
     * @return mixed
     */
    public static function get(string $key, $default = null)
    {
        return $_SESSION[$key] ?? $default;
    }

    /**
     * Remove a session variable.
     *
     * @param string $key
     */
    public static function forget(string $key): void
    {
        unset($_SESSION[$key]);
    }
}
