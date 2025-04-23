<?php

namespace Core;

/**
 * Class Controller
 *
 * Base controller class for all application controllers.
 *
 * @package Core
 */
class Controller
{
    /**
     * Render a view file.
     *
     * @param string $view
     * @param array $data
     * @return void
     */
    protected function view(string $view, array $data = []): void
    {
        extract($data);
        $viewPath = __DIR__ . '/../app/Views/' . str_replace('.', '/', $view) . '.php';

        if (file_exists($viewPath)) {
            require $viewPath;
        } else {
            echo "View [$view] not found.";
        }
    }
}
