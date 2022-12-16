<?php

namespace App;

use App\Exceptions\RouteNotFoundException;

class Router
{
    private array $routes = [];
    private array $middleware = [];

    public function register(
        string $method,
        string $route,
        $action,
        array $middleware = []
    ) {
        $this->routes[$method][$route] = $action;
        $this->middleware[$method][$route] = $middleware;
    }

    public function resolve(string $uri, string $method)
    {
        // Pasiemam route, ji pasidalinam i masyva ?foo=bar
        $route = explode('?', $uri)[0];
        $method = strtolower($method);
        $action = $this->routes[$method][$route] ?? null;
        $middleware = $this->middleware[$method][$route] ?? null;
        
        if (!empty($middleware)) {
            foreach ($middleware as $mid) {
                call_user_func_array([$mid, 'handle'], []);
                if (class_exists($mid)) {
                    call_user_func_array([$mid, 'handle'], []);
                }
            }
        }

        if (!$action) {
            throw new RouteNotFoundException();
        }
        
        if (is_callable($action)) {
            return call_user_func($action);
        }

        if (is_array($action)) {

            [$class, $method] = $action;
            // pasitikrinam ar controleri/clase egzistuoja

            if (class_exists($class)) {
                //suskuriam objekta is klases
                $object = new $class;
                //ar metodas egzistuoja
                if (method_exists($object, $method)) {
                    //isvieciam objekto metoda
                    return call_user_func_array([$object, $method], []);
                }
            }
        }

        throw new RouteNotFoundException();
    }
}
