<?php

namespace BarberAgenda\Bootstrap;

use BarberAgenda\Utils\Types\Route;
use BarberAgenda\Config\Router;

class App {
    
    public function run(): void {
        $this->defineRoutes();
        Router::handle($_SERVER["REQUEST_METHOD"], [
            "path" => parse_url($_SERVER["REQUEST_URI"], PHP_URL_PATH),
            "query" => explode("=", parse_url($_SERVER["REQUEST_URI"], PHP_URL_QUERY) ?? '')
        ]);
    }

    public function defineRoutes() : void {
        $routes = [
            new Route('GET', '/', function () { echo json_encode(["message" => "Hello, world!"]); }),
            new Route('GET', '/schedules', 'ScheduleController@index'),
            new Route('POST', '/schedules', 'ScheduleController@create'),
            new Route('GET', '/schedule', 'ScheduleController@show'),
            new Route('PUT', '/schedule', 'ScheduleController@update'),
            new Route('DELETE', '/schedule', 'ScheduleController@destroy'),
        ];

        foreach ($routes as $route) {
            Router::add($route);
        }
    }
}