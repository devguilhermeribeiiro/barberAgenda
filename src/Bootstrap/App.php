<?php

namespace BarberAgenda\Bootstrap;

use BarberAgenda\Utils\Types\Route;
use BarberAgenda\Config\Router;

class App {
    
    public function run(): void {
        $this->defineRoutes();
        Router::handle();
    }

    public function defineRoutes() : void {
        Router::get('/{name}', function ($name) {
            echo json_encode(["message" => "Hello, $name."]);
        });
    }
}