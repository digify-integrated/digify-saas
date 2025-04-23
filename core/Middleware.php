<?php

namespace Core;

/**
 * Interface Middleware
 *
 * Interface for middleware classes to implement.
 *
 * @package Core
 */
interface Middleware
{
    /**
     * Handle the incoming request.
     *
     * @param Request $request
     * @return void
     */
    public function handle(Request $request): void;
}
