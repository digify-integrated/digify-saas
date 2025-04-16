<?php

namespace App\Middleware;

use App\Core\Response;
use App\Core\Session;

/**
 * AuthMiddleware handles user authentication.
 * This middleware checks if the user is logged in before allowing access to protected routes.
 *
 * @package App\Middleware
 */
class AuthMiddleware implements MiddlewareInterface
{
    /**
     * Handle the request to check if the user is authenticated.
     *
     * @return bool Return true if the user is authenticated, false otherwise.
     */
    public function handle(): bool
    {
        // If the user is not logged in, redirect to the login page
        if (!Session::get('user')) {
            Response::status(401);
            echo "401 Unauthorized: Please log in.";
            return false;
        }

        return true;
    }
}
