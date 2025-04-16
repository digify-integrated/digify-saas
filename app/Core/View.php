<?php

namespace App\Core;

/**
 * Class View
 *
 * Handles rendering view files, extracting data and making them available in the view scope.
 * It ensures that the view file is found and renders the appropriate content to the user.
 *
 * @package App\Core
 */
class View
{
    /**
     * Render a view file with data.
     * This method extracts the provided data into variables and then includes the corresponding view file.
     *
     * @param string $view The path to the view file, relative to the /views directory (e.g., 'home/index').
     * @param array $data Associative array of data to extract into the view scope.
     * @return void
     */
    public static function render(string $view, array $data = []): void
    {
        // Construct the full view path based on the provided view name
        $viewPath = __DIR__ . '/../Views/' . str_replace('.', '/', $view) . '.php';

        // Check if the view file exists
        if (!file_exists($viewPath)) {
            // Provide an informative error message if the view does not exist
            http_response_code(500);
            echo "View '{$view}' not found at '{$viewPath}'.";
            return;
        }

        // Extract data into variables for use within the view
        extract($data, EXTR_SKIP);

        // Include the view file to render it
        require_once $viewPath;
    }
}
