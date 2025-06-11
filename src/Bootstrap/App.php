<?php

namespace BarberAgenda\Bootstrap;

use BarberAgenda\Config\Router;

class App {
    
    public function run(): void {
        $this->defineRoutes();
        Router::handle();
    }

    public function defineRoutes() : void {
        Router::get('/name/{name}', function ($name) {
            echo json_encode(["message" => "Hello, $name."]);
        });
        
        Router::get('/schedules', 'ScheduleController@index');

        Router::post('/schedules', 'ScheduleController@create');

        Router::get('/schedules/{id}', 'ScheduleController@show');

        Router::post('/schedules/{id}', 'ScheduleController@update');

        Router::post('/schedules/{id}/destroy', 'ScheduleController@destroy');
    }
}