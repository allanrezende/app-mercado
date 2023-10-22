<?php

namespace AllanRezende\AppMercado\Core;

use Exception;

class Router {

    private $routes;

    public function addRoute( string $method, string $path, $handler ): void {
        $this->routes[$method . " ". $path] = $handler;
    }

    public function resolve() { 

        $request = new Request();
        $response = new Response();
        
        $callback = $this->routes[$request->getMethod() . ' ' . $request->getPath()] ?? false;
        
        if ($callback === false) {
            $response->notFound();
        } else {
            try {
                return call_user_func_array($callback, [$request, $response]);
            } catch (Exception $exception) {
                return $exception->getMessage();
            }
        }
    }
}