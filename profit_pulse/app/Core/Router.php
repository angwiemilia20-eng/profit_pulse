<?php

namespace App\Core;

class Router
{
    private array $routes = [];

    public function get(string $path, array $handler): self
    {
        $this->routes['GET'][$this->normalize($path)] = $handler;
        return $this;
    }

    public function post(string $path, array $handler): self
    {
        $this->routes['POST'][$this->normalize($path)] = $handler;
        return $this;
    }

    public function dispatch(string $uri, string $method): void
    {
        $uri = $this->normalize(parse_url($uri, PHP_URL_PATH) ?: '/');
        $method = strtoupper($method);

        $handler = $this->routes[$method][$uri] ?? null;

        if (!$handler) {
            http_response_code(404);
            View::render('errors/404', [], 'auth');
            return;
        }

        [$controllerClass, $action] = $handler;
        $controller = new $controllerClass();

        if (!method_exists($controller, $action)) {
            http_response_code(500);
            die("Action {$action} not found.");
        }

        $controller->$action();
    }

    private function normalize(string $path): string
    {
        $path = trim($path, '/');
        $base = trim(parse_url(APP_URL, PHP_URL_PATH) ?? '', '/');

        if ($base && str_starts_with($path, $base)) {
            $path = trim(substr($path, strlen($base)), '/');
        }

        return $path === '' ? '/' : $path;
    }
}
