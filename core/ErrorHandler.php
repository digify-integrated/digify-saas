<?php

namespace Core;

/**
 * Class ErrorHandler
 *
 * Centralized error and exception handler.
 *
 * @package Core
 */
class ErrorHandler
{
    /**
     * Register error and exception handling.
     *
     * @return void
     */
    public static function register(): void
    {
        ini_set('display_errors', $_ENV['APP_DEBUG'] === 'true' ? '1' : '0');
        error_reporting(E_ALL);

        set_exception_handler([self::class, 'handleException']);
        set_error_handler([self::class, 'handleError']);
    }

    /**
     * Handle exceptions.
     *
     * @param \Throwable $e
     * @return void
     */
    public static function handleException(\Throwable $e): void
    {
        http_response_code(500);

        if ($_ENV['APP_DEBUG'] === 'true') {
            echo "<pre><strong>Exception:</strong> {$e->getMessage()}\n\n{$e->getTraceAsString()}</pre>";
        } else {
            echo "Something went wrong.";
        }
    }

    /**
     * Handle PHP errors.
     *
     * @param int $severity
     * @param string $message
     * @param string $file
     * @param int $line
     * @return void
     */
    public static function handleError(int $severity, string $message, string $file, int $line): void
    {
        self::handleException(new \ErrorException($message, 0, $severity, $file, $line));
    }
}
