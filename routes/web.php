<?php

use App\Controllers\HomeController;
use App\Controllers\UserController;

$router->get('/', [HomeController::class, 'index']);
$router->get('/users/{id}', [UserController::class, 'show']);
$router->post('/submit', [HomeController::class, 'submit']);
