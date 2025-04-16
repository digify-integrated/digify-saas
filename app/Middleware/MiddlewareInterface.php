<?php

namespace App\Middleware;

/**
 * Interface MiddlewareInterface
 *
 * Defines the structure for all middleware classes in the application.
 * Middleware classes are used to filter and process incoming requests.
 *
 * @package App\Middleware
 */
interface MiddlewareInterface
{
    /**
     * Handle the incoming request.
     *
     * This method is called for each middleware in the stack. The middleware can
     * either allow the request to continue or stop it (by returning false).
     *
     * @return bool Return true to allow the request to continue, false to stop it.
     */
    public function handle(): bool;
}
