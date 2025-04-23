<?php

namespace Core;

use Core\Request;
use Core\Response;

/**
 * Class Router
 *
 * Handles HTTP route registration and resolution.
 *
 * @package Core
 */
class Router
{
    protected array $routes = [
        'GET' => [],
        'POST' => [],
    ];

    /**
     * Add a GET route.
     */
    public function get(string $uri, callable|array $action): void
    {
        $this->addRoute('GET', $uri, $action);
    }

    /**
     * Add a POST route.
     */
    public function post(string $uri, callable|array $action): void
    {
        $this->addRoute('POST', $uri, $action);
    }

    /**
     * Add a route.
     */
    protected function addRoute(string $method, string $uri, callable|array $action): void
    {
        $this->routes[$method][$uri] = $action;
    }

    /**
     * Dispatch request to appropriate route.
     */
    public function dispatch(Request $request, Response $response): void
    {
        $method = $request->method();
        $uri = rtrim($request->uri(), '/') ?: '/';

        foreach ($this->routes[$method] as $route => $action) {
            $pattern = preg_replace('#\{[a-zA-Z_]+\}#', '([^/]+)', $route);
            $pattern = "#^" . rtrim($pattern, '/') . "$#";

            if (preg_match($pattern, $uri, $matches)) {
                array_shift($matches); // Remove full match
                return $this->execute($action, $request, $response, $matches);
            }
        }

        http_response_code(404);
        echo "404 Not Found";
    }

    /**
     * Execute the route action.
     */
    protected function execute(callable|array $action, Request $request, Response $response, array $params): void
    {
        if (is_array($action)) {
            [$controller, $method] = $action;
            $controllerInstance = new $controller;

            // Optional middleware support in controller
            if (method_exists($controllerInstance, 'middleware')) {
                foreach ($controllerInstance->middleware() as $middlewareClass) {
                    (new $middlewareClass())->handle($request);
                }
            }

            call_user_func_array([$controllerInstance, $method], $params);
        } else {
            call_user_func_array($action, $params);
        }
    }
}
