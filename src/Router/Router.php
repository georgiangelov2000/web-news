<?php

namespace App\Router;

class Router
{
    private array $routes = [];

    public function register(array $routes): void
    {
        $this->routes = $routes;
    }

    public function dispatch(string $requestUri, array $queryParams = []): void
    {
        foreach ($this->routes as $pattern => $handler) {
            if (preg_match($pattern, $requestUri, $matches)) {
                $params = array_filter($matches, 'is_string', ARRAY_FILTER_USE_KEY);
                $params['query'] = $queryParams;
                $params['requestUri'] = $requestUri;
                $handler($params);
                return;
            }
        }
        // Not found fallback
        http_response_code(404);
        $view = new \App\View\ViewRenderer(__DIR__ . '/../../templates');
        echo $view->render('notfound', ['template' => $requestUri]);
    }
}