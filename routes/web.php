<?php

use App\Core\Router;

// Use singleton instance
$router = Router::getInstance();

$router->get('/login', 'UserController@showLoginForm', [], 'login');
$router->post('/login', 'UserController@login', [], 'login.submit');

$router->get('/register', 'UserController@showRegisterForm', [], 'register');
$router->post('/register', 'UserController@register', [], 'register.submit');

$router->get('/forgot-password', 'UserController@showForgotPasswordForm', [], 'forgot-password');
