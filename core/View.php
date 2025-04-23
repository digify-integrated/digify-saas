<?php

namespace Core;

/**
 * Class View
 *
 * Responsible for rendering views with data.
 *
 * @package Core
 */
class View
{
    /**
     * Render a view file.
     *
     * @param string $view
     * @param array $data
     * @return void
     */
    public static function render(string $view, array $data = []): void
    {
        extract($data);
        $path = __DIR__ . '/../app/Views/' . str_replace('.', '/', $view) . '.php';

        if (!file_exists($path)) {
            echo "View [$view] not found.";
            return;
        }

        require $path;
    }
}
