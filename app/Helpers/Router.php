<?php

namespace App\Helpers;

class Router {
    private $routes = [];

    public function get($uri, $action) {
        $this->addRoute('GET', $uri, $action);
    }

    public function post($uri, $action) {
        $this->addRoute('POST', $uri, $action);
    }

    public function put($uri, $action) {
        $this->addRoute('PUT', $uri, $action);
    }

    public function delete($uri, $action) {
        $this->addRoute('DELETE', $uri, $action);
    }

    private function addRoute($method, $uri, $action) {
        $this->routes[] = [
            'method' => $method,
            'uri' => $uri,
            'action' => $action
        ];
    }

    public function handleRequest() {
        $requestMethod = $_SERVER['REQUEST_METHOD'];
        $requestUri = strtok($_SERVER['REQUEST_URI'], '?');

        foreach ($this->routes as $route) {
            if ($route['method'] === $requestMethod && preg_match($this->convertUriToRegex($route['uri']), $requestUri, $matches)) {
                list($controller, $method) = explode('@', $route['action']);

                $controllerClass = "App\\Http\\Controllers\\" . $controller;
                $controllerInstance = new $controllerClass();

                array_shift($matches);

                return call_user_func_array([$controllerInstance, $method], $matches);
            }
        }

        http_response_code(404);
        return json_encode(['message' => 'Endpoint not found']);
    }

    private function convertUriToRegex($uri) {
        $regex = preg_replace('/\{([a-zA-Z0-9_]+)\}/', '([a-zA-Z0-9_]+)', $uri);
        return "#^" . $regex . "$#";
    }
}