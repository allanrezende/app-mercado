<?php

namespace AllanRezende\AppMercado\Core;

class Request {
    
    public function getPath() {
        $uri = parse_url($_SERVER['REQUEST_URI']);
        $path = $uri['path'];
        return $path;
    }

    public function getParams(): array {
        return $_REQUEST;
    }

    public function getMethod() {
        $method = $_SERVER['REQUEST_METHOD'];
        return $method;
    }
}