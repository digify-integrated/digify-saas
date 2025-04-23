<?php

namespace Core;

/**
 * Class Response
 *
 * Responsible for sending HTTP responses to the client.
 *
 * @package Core
 */
class Response
{
    /**
     * Send a plain text response.
     *
     * @param string $content
     * @param int $status
     * @return void
     */
    public function send(string $content, int $status = 200): void
    {
        http_response_code($status);
        echo $content;
    }

    /**
     * Redirect to a given path.
     *
     * @param string $path
     * @return void
     */
    public function redirect(string $path): void
    {
        header("Location: {$path}");
        exit;
    }

    /**
     * Send a JSON response.
     *
     * @param array $data
     * @param int $status
     * @return void
     */
    public function json(array $data, int $status = 200): void
    {
        http_response_code($status);
        header('Content-Type: application/json');
        echo json_encode($data);
    }
}
