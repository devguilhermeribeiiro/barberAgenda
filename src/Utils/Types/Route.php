<?php

namespace BarberAgenda\Utils\Types;

class Route {
    private string $method;
    private string $path;
    private $callback;

    public function __construct(string $method, string $path, $callback) {
        $this->method = $method;
        $this->path = $path;
        $this->callback = $callback;
    }

    public function method() { return $this->method; }
    public function path() { return $this->path; }
    public function callback() { return $this->callback; }
}