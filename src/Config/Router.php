<?php

namespace BarberAgenda\Config;

use BarberAgenda\Utils\Types\Route;

class Router {
    private static array $routes = [];

    public static function add(Route $route): void {
        array_push(self::$routes, $route);
    }

    public static function handle(string $requestMethod, array $requestUri) {
        foreach (self::$routes as $route) {
            if (!$requestMethod == strtoupper($route->method()) && $requestUri["path"] == $route->path()) {
                http_response_code(404);
                echo json_encode(["error" => "route not found."]);
            }

            if (!is_callable($route->callback())) {
                if (!str_contains("@", $route->callback())) {
                    echo json_encode(["error" => "invalid callback"]);
                }
                
                [$controllerName, $action] = explode("@", $route->callback());

                $controller = "\\BarberAgenda\\Controllers\\" . $controllerName;

                if (!class_exists($controller) && method_exists($controller, $action)) {
                    http_response_code(400);
                    echo json_encode(["error" => "invalid callback"]);
                }
                $dependencies = new DependencyContainer();
                $controller = new $controller($dependencies->inject());

                call_user_func_array([$controller, $action], $requestUri["query"]);
            }

            call_user_func($route->callback(), array_pop($requestUri["query"]));
        }
    }
}