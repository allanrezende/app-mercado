<?php

namespace AllanRezende\AppMercado\Core;

class App {
    
    public Router $router;
    public Request $request;
    public Response $response;

    public function __construct() {
        $this->request = new Request();
        $this->response = new Response();
        $this->router = new Router();
    }
    
    public function get(string $path, $handler): void {
        $this->router->addRoute('GET', $path, $handler);
    }

    public function post(string $path, $handler): void {
        $this->router->addRoute('POST', $path, $handler);
    }
    
    public function put(string $path, $handler): void {
        $this->router->addRoute('PUT', $path, $handler);
    }
    
    public function delete(string $path, $handler): void {
        $this->router->addRoute('DELETE', $path, $handler);
    }

    public function run() {
        echo $this->router->resolve();
    }
}