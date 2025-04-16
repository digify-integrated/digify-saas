<?php

use App\Core\Session;
use App\Core\Response;
use App\Core\Router;

/**
 * Escape HTML output to prevent XSS attacks.
 */
function e(string $string): string
{
    return htmlspecialchars($string, ENT_QUOTES, 'UTF-8');
}

/**
 * Debugging helper to dump variables and halt execution.
 */
function dd(...$vars): void
{
    echo '<pre>';
    foreach ($vars as $var) {
        var_dump($var);
    }
    echo '</pre>';
    die();
}

/**
 * Redirect to a given URL.
 */
function redirect(string $url): void
{
    Response::redirect($url);
}

/**
 * Generate a CSRF token and store it in session.
 */
function csrf_token(): string
{
    $token = bin2hex(random_bytes(32));
    Session::set('_csrf_token', $token);
    return $token;
}

/**
 * Verify the CSRF token against the session value.
 */
function csrf_verify(string $token): bool
{
    $sessionToken = Session::get('_csrf_token');
    Session::remove('_csrf_token');
    return hash_equals($sessionToken ?? '', $token);
}

/**
 * Include a view component.
 */
function viewComponent(string $name)
{
    $path = __DIR__ . "/Views/components/{$name}.php";
    if (file_exists($path)) {
        include $path;
    }
}

/**
 * Generate a URL for a named route.
 *
 * @param string $name
 * @param array $params
 * @return string
 */
function route(string $name, array $params = []): string
{
    $router = Router::getInstance();
    return $router->generateUrl($name, $params);
}
