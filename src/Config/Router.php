<?php

use BarberAgenda\Utils\Types\Route;
use BarberAgenda\Controllers;

class Router {
    private array $routes;

    public function add(Route $route): void {
        array_push($routes, $route);
    }

    public function handle(string $requestMethod, array $requestUri) {
        foreach ($this->routes as $route) {
            if (!$requestMethod == strtoupper($route->method()) && $requestUri["path"] == $route->path()) {
                http_response_code(404);
                return json_encode(["error" => "route not found."]);
            }

            if (!is_callable($route->callback())) {
                if (!str_contains("@", $route->callback())) {
                    http_response_code(400);
                    return json_encode(["error" => "invalid callback"]);
                }
                
                [$controller, $action] = explode("@", $route->callback());

                if (!class_exists($controller) && method_exists($controller, $action)) {
                    http_response_code(400);
                    return json_encode(["error" => "invalid callback"]);
                }
                
                call_user_func_array([$controller, $action], array_pop($requestUri["query"]));
            }

            call_user_func($route->callback(), array_pop($requestUri["query"]));
        }
    }
}