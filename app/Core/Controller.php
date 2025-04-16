<?php

namespace App\Core;

/**
 * Class Controller
 *
 * The base controller class. All other controllers should extend this class.
 * Provides helper methods to render views and perform redirects.
 *
 * @package App\Core
 */
abstract class Controller
{
    /**
     * Render a view file with optional data.
     *
     * @param string $view The view file to render, relative to the /views directory (e.g., 'home/index').
     * @param array $data Optional associative array of data to pass to the view.
     */
    protected function view(string $view, array $data = []): void
    {
        // Calls the View class to render the specified view file
        View::render($view, $data);
    }

    /**
     * Redirect to another URL or route.
     *
     * @param string $url The URL or route to redirect to.
     */
    protected function redirect(string $url): void
    {
        header("Location: {$url}");
        exit; // Ensure the script stops executing after the redirect
    }
}
