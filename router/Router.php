<?php

namespace router;

use Exception;
use function app\internalServerErrorResponse;
use function util\printStackTrace;

class Router
{
    private array $routes = array();
    private $callbackNotFound = null;

    public function group(string $route): Router
    {
        $group = new Router();
        $this->routes[$route] = $group;
        return $group;
    }

    public function route(string $route, string $method)
    {
        $callback = $this->getCallback(self::routeToArr($route), $method);
        if (!is_null($callback))
        {
            try
            {
                call_user_func($callback);
            }
            catch (Exception $e)
            {
                internalServerErrorResponse();
                printStackTrace($e);
                return;
            }
        }
        else if (!is_null($this->callbackNotFound))
        {
            call_user_func($this->callbackNotFound);
        }
    }

    private function getCallback(array $route, string $method)
    {
        if (!array_key_exists($route[0], $this->routes))
            return null;
        if (is_array($this->routes[$route[0]]))
        {
            if (!array_key_exists($method, $this->routes[$route[0]]))
                return null;
            if (count($route) > 1)
                return null;
            return $this->routes[$route[0]][$method];
        }
        else
        {
            /* @var $inner_router Router */
            $inner_router = $this->routes[$route[0]];
            return $inner_router->getCallback(array_slice($route, 1), $method);
        }
    }

    private function setCallback(array $route, string $method, $callback)
    {
        if (array_key_exists($route[0], $this->routes)) {
            if (is_array($this->routes[$route[0]]))
            {
                $this->routes[$route[0]][$method] = $callback;
            }
            else // Router
            {
                /* @var $inner_router Router */
                $inner_router = $this->routes[$route[0]];
                $inner_router->setCallback(array_slice($route, 1), $method, $callback);
            }
        } else {
            if (count($route) == 1)
            {
                $this->routes[$route[0]] = array(
                    $method => $callback,
                );
            } else {
                $router = new Router();
                $this->routes[$route[0]] = $router;
                $router->setCallback(array_slice($route, 1), $method, $callback);
            }
        }
    }

    private function routeToArr(string $path): array
    {
        $route = explode('/', trim($path, '/'));
        if (count($route) == 0)
        {
            return [""];
        }
        return $route;
    }

    private function endpoint(string $route, string $method, $callback)
    {
        $this->setCallback(self::routeToArr($route), $method, $callback);
    }

    public function GET(string $route, $callback)
    {
        $this->endpoint($route, 'GET', $callback);
    }

    public function POST(string $route, $callback)
    {
        $this->endpoint($route, 'POST', $callback);
    }

    public function setCallbackNotFound($callback)
    {
        $this->callbackNotFound = $callback;
    }
}