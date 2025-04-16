<?php

namespace App\Core;

use App\Middleware\MiddlewareInterface;

/**
 * Router
 *
 * A minimalistic yet powerful routing class with support for named routes and middleware.
 */
class Router
{
    protected array $routes = [
        'GET' => [],
        'POST' => [],
    ];

    protected array $namedRoutes = [];

    protected static ?Router $instance = null;

    /**
     * Retrieve the singleton instance of the router.
     */
    public static function getInstance(): self
    {
        if (!self::$instance) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    /**
     * Register a GET route.
     */
    public function get(string $uri, $callback, array $middleware = [], ?string $name = null): void
    {
        $this->addRoute('GET', $uri, $callback, $middleware, $name);
    }

    /**
     * Register a POST route.
     */
    public function post(string $uri, $callback, array $middleware = [], ?string $name = null): void
    {
        $this->addRoute('POST', $uri, $callback, $middleware, $name);
    }

    /**
     * Register a route internally.
     */
    protected function addRoute(string $method, string $uri, $callback, array $middleware, ?string $name): void
    {
        $this->routes[$method][$uri] = [
            'callback' => $callback,
            'middleware' => $middleware
        ];

        if ($name) {
            $this->namedRoutes[$name] = $uri;
        }
    }

    /**
     * Dispatch the incoming request.
     */
    public function dispatch(string $uri): void
    {
        $uri = $this->normalizeUri($uri);
        $method = $_SERVER['REQUEST_METHOD'];
        $match = $this->findRoute($method, $uri);

        if (!$match) {
            http_response_code(404);
            echo "404 Not Found: No route matched for URI '{$uri}' with method '{$method}'";
            return;
        }

        if (!$this->executeMiddleware($match['middleware'])) {
            return;
        }

        $this->dispatchCallback($match['callback'], $match['params'] ?? []);
    }

    /**
     * Normalize request URI.
     */
    protected function normalizeUri(string $uri): string
    {
        $uri = parse_url($uri, PHP_URL_PATH);
        return '/' . trim(str_replace($_ENV['APP_BASE_PATH'] ?? '', '', $uri), '/');
    }

    /**
     * Find matching route for method and URI.
     */
    protected function findRoute(string $method, string $uri): ?array
    {
        foreach ($this->routes[$method] as $route => $data) {
            $pattern = preg_replace('/\{([a-zA-Z0-9_]+)\}/', '([^/]+)', $route);
            $regex = "#^{$pattern}$#";

            if (preg_match($regex, $uri, $matches)) {
                array_shift($matches);
                return [
                    'callback' => $data['callback'],
                    'params' => $matches,
                    'middleware' => $data['middleware'] ?? []
                ];
            }
        }

        return null;
    }

    /**
     * Execute route middleware.
     */
    protected function executeMiddleware(array $middleware): bool
    {
        foreach ($middleware as $middlewareClass) {
            if (!class_exists($middlewareClass)) {
                http_response_code(500);
                echo "Middleware '{$middlewareClass}' not found.";
                return false;
            }

            $instance = new $middlewareClass();

            if (!$instance instanceof MiddlewareInterface || !$instance->handle()) {
                return false;
            }
        }

        return true;
    }

    /**
     * Execute controller or closure.
     */
    protected function dispatchCallback($callback, array $params): void
    {
        if (is_callable($callback)) {
            call_user_func_array($callback, $params);
        } elseif (is_string($callback)) {
            $this->callController($callback, $params);
        } else {
            http_response_code(500);
            echo "Invalid callback";
        }
    }

    /**
     * Dispatch to controller.
     */
    protected function callController(string $controllerAction, array $params): void
    {
        [$controller, $method] = explode('@', $controllerAction);
        $class = 'App\\Controllers\\' . $controller;

        if (!class_exists($class) || !method_exists($class, $method)) {
            http_response_code(500);
            echo "Controller or method not found: {$class}@{$method}";
            return;
        }

        $instance = new $class();
        call_user_func_array([$instance, $method], $params);
    }

    /**
     * Generate a URL by named route and parameters.
     */
    public function generateUrl(string $name, array $params = []): string
    {
        if (!isset($this->namedRoutes[$name])) {
            throw new \Exception("Route '{$name}' is not defined.");
        }

        $path = $this->namedRoutes[$name];

        foreach ($params as $value) {
            $path = preg_replace('/\{[^}]+\}/', $value, $path, 1);
        }

        $base = $_ENV['APP_BASE_PATH'] ?? '';
        return rtrim($base, '/') . $path;
    }
}
