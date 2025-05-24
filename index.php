<?php

require_once __DIR__ . '/bootstrap.php';

use Slim\Psr7\Factory\ServerRequestFactory;
use PhpDevCommunity\Router;

$routes = require __DIR__ . '/routes.php';

$router = new Router($routes, 'http://localhost');

try {
    $request = ServerRequestFactory::createFromGlobals();
    $route = $router->match($request);

    $handler = $route->getHandler();
    $attributes = $route->getAttributes();
    $controllerName = $handler[0];
    $methodName = $handler[1] ?? null;

    $controller = new $controllerName();
    if (!is_callable($controller)) {
        $controller = [$controller, $methodName];
    }

    echo $controller($attributes, ...array_values($attributes));
} catch (\PhpDevCommunity\Exception\MethodNotAllowed $exception) {
    header("HTTP/1.0 405 Method Not Allowed");
    exit();
} catch (\PhpDevCommunity\Exception\RouteNotFound $exception) {
    header("HTTP/1.0 404 Not Found");
    exit();
}
