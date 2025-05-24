<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require __DIR__ . '/vendor/autoload.php';

use App\Session\Session;
use App\Security\RateLimiter;
use App\Security\SessionGuard;
use Slim\Psr7\Factory\ServerRequestFactory;

$session = new Session(__DIR__ . '/storage/session');

// Session security
$guard = new SessionGuard($session);
$guard->enforce();

// Rate limiting
$clientIp = $_SERVER['HTTP_X_FORWARDED_FOR'] ?? $_SERVER['REMOTE_ADDR'] ?? '';
$limiter = new RateLimiter(__DIR__ . '/../storage/ratelimit/');
$limiter->check($clientIp);

// Load routes
$routes = require __DIR__ . '/routes.php';

// Initialize the router
$router = new \PhpDevCommunity\Router($routes, 'http://localhost');

// Handle the request
try {
    // Match incoming request
    $request = ServerRequestFactory::createFromGlobals();
    $route = $router->match($request);

    // Handle the matched route
    $handler = $route->getHandler();
    $attributes = $route->getAttributes();
    $controllerName = $handler[0];
    $methodName = $handler[1] ?? null;

    $controller = new $controllerName();
    // Invoke the controller method
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