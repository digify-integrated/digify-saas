<?php

namespace Core;

/**
 * Class Csrf
 *
 * Provides CSRF protection through token generation and validation.
 *
 * @package Core
 */
class Csrf
{
    /**
     * Start session and generate token if needed.
     */
    public static function init(): void
    {
        Session::start();

        if (!Session::get('_csrf_token')) {
            self::generateToken();
        }
    }

    /**
     * Generate a new CSRF token.
     *
     * @return void
     */
    public static function generateToken(): void
    {
        $token = bin2hex(random_bytes(32));
        Session::set('_csrf_token', $token);
    }

    /**
     * Get the current CSRF token.
     *
     * @return string|null
     */
    public static function token(): ?string
    {
        return Session::get('_csrf_token');
    }

    /**
     * Validate a submitted token.
     *
     * @param string|null $token
     * @return bool
     */
    public static function validate(?string $token): bool
    {
        return hash_equals(self::token() ?? '', $token ?? '');
    }

    /**
     * Include CSRF input field in HTML forms.
     *
     * @return string
     */
    public static function input(): string
    {
        return '<input type="hidden" name="_csrf_token" value="' . htmlspecialchars(self::token()) . '">';
    }
}
