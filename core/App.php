<?php

namespace Core;

use Core\Router;

/**
 * Class App
 *
 * The core application class responsible for initializing
 * and running the framework lifecycle.
 *
 * @package Core
 */
class App
{
    /**
     * The Router instance.
     *
     * @var Router
     */
    protected Router $router;

    /**
     * App constructor.
     *
     * Initializes the Router.
     */
    public function __construct()
    {
        $this->router = new Router();
    }

    /**
     * Define application routes.
     *
     * @param callable $routes
     * @return void
     */
    public function routes(callable $routes): void
    {
        $routes($this->router);
    }

    /**
     * Run the application and handle the current request.
     *
     * @return void
     */
    public function run(): void
    {
        $this->router->dispatch();
    }
}
