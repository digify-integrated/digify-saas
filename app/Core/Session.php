<?php

namespace App\Core;

/**
 * Class Session
 *
 * A helper class to manage PHP sessions, including start, set, get, and remove session variables,
 * along with flash messages.
 *
 * @package App\Core
 */
class Session
{
    /**
     * Start the session if not already started.
     * This method ensures that the session is started only once during the lifecycle.
     *
     * @return void
     */
    public static function start(): void
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
    }

    /**
     * Set a session key with a given value.
     * This stores a value in the session, accessible throughout the session's lifetime.
     *
     * @param string $key The session key to set.
     * @param mixed $value The value to store.
     * @return void
     */
    public static function set(string $key, $value): void
    {
        $_SESSION[$key] = $value;
    }

    /**
     * Get the value of a session key.
     * If the key does not exist, the default value will be returned.
     *
     * @param string $key The session key to retrieve.
     * @param mixed $default The default value if the session key is not set.
     * @return mixed The session value or the default if not set.
     */
    public static function get(string $key, $default = null)
    {
        return $_SESSION[$key] ?? $default;
    }

    /**
     * Remove a session key from the session.
     * This will unset the session variable for the provided key.
     *
     * @param string $key The session key to remove.
     * @return void
     */
    public static function remove(string $key): void
    {
        unset($_SESSION[$key]);
    }

    /**
     * Destroy the session completely.
     * This will clear all session data and destroy the session.
     *
     * @return void
     */
    public static function destroy(): void
    {
        $_SESSION = [];
        session_destroy();
    }

    /**
     * Set a one-time flash message to be used after the next page load.
     * Flash messages are stored temporarily and removed after being accessed.
     *
     * @param string $key The flash message key.
     * @param string|null $message The message to set (null to retrieve the message).
     * @return string|null The stored flash message, or null if none exists.
     */
    public static function flash(string $key, string $message = null): ?string
    {
        if ($message !== null) {
            $_SESSION['_flash'][$key] = $message;
        } else {
            $msg = $_SESSION['_flash'][$key] ?? null;
            unset($_SESSION['_flash'][$key]);
            return $msg;
        }

        return null;
    }
}
