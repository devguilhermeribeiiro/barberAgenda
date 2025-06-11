<?php

namespace BarberAgenda\Config;

class Router {
    private static $routes;

    public static function add($method, $path, $callback): void {
        self::$routes[] = [
            "method" => $method,
            "path" => $path,
            "callback" => $callback,
        ];
    }

    public static function handle() {
        $requestMethod = $_SERVER["REQUEST_METHOD"];
        $requestUri = parse_url($_SERVER["REQUEST_URI"], PHP_URL_PATH);

        foreach (self::$routes as $route) {
            $paramsPattern = '#^' . preg_replace('/\{([\w]+)\}/', '([^/]+)', $route["path"]) . '$#';
            $url_params = [];

            if ($requestMethod === $route["method"] && preg_match($paramsPattern, $requestUri, $url_params)) {
                array_shift($url_params);
                print_r($url_params);

                if (is_string($route["callback"]) && str_contains($route["callback"], "@")) {
    
                    [$controllerName, $action] = explode("@", $route["callback"]);
        
                    $controller = "\\BarberAgenda\\Controllers\\" . $controllerName;
        
                    if (!class_exists($controller)) {
                        echo json_encode(["error" => "invalid callback"]);
                        return;
                    }
        
                    $dependencies = new DependencyContainer();
                    $controller = new $controller($dependencies->inject());
        
                    call_user_func_array([$controller, $action], $url_params);
    
                    return;
                } 
                elseif (is_callable($route["callback"])) {
                    call_user_func_array($route["callback"], $url_params);
                    
                    return; 
                }
                else {
                    echo json_encode(["error" => "invalid callback"]);
                    return;
                }
            }
        }

        http_response_code(404);
        echo json_encode("Not found");
    }

    public static function get($path, $callback)
    {
        self::add('GET', $path, $callback);
    }

    public static function post($path, $callback)
    {
        self::add('POST', $path, $callback);
    }

    public static function put($path, $callback)
    {
        self::add('PUT', $path, $callback);
    }

    public static function delete($path, $callback)
    {
        self::add('DELETE', $path, $callback);
    }

}