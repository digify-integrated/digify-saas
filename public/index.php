<?php

ini_set('display_errors', 1);
error_reporting(E_ALL);

require_once __DIR__ . '/../vendor/autoload.php';
require_once __DIR__ . '/../config/config.php';

use App\Core\Env;
use App\Core\Session;
use App\Core\Router;

Env::load();
Session::start();

// Use singleton Router
$router = Router::getInstance();
require_once __DIR__ . '/../routes/web.php';

// Dispatch request
$router->dispatch($_SERVER['REQUEST_URI']);
