<?php
require __DIR__ . '/vendor/autoload.php';

use App\Session\Session;
use App\Router\Router;

$session = new Session(__DIR__ . '/storage/session');
$session->set('counter', $session->get('counter', 0) + 1);

$routes = require __DIR__ . '/routes.php';

$requestUri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$queryString = $_SERVER['QUERY_STRING'] ?? '';

parse_str($queryString, $queryParams);

$router = new Router();
$router->register($routes);
$router->dispatch($requestUri, $queryParams);