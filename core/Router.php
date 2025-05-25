<?php

namespace MVCore;

class Router
{
    public Request $request;
    public Response $response;

    protected array $routes = [];
    public array $route_params = [];

    public function __construct(Request $request, Response $response)
    {
        $this->request = $request;
        $this->response = $response;
    }

    public function getRoutes(): array
    {
        return $this->routes;
    }

    public function get($path, $callback): void
    {
        $path = trim($path, '/');
        $this->routes['GET']["/{$path}"] = $callback;
    }

    public function post($path, $callback): void
    {
        $this->routes['POST'][$path] = $callback;
    }

    public function dispatch(): mixed
    {
        $path = $this->request->getPath();
        $method = $this->request->getMethod();
        $callback = $this->matchRoute($method, $path);

        if (false === $callback) {
            abort();
        }

        if (is_array($callback)) {
            $callback[0] = new $callback[0];
        }

        return call_user_func($callback);
    }

    private function matchRoute($method, $path)
    {
        foreach ($this->routes[$method] as $pattern => $route) {
            if (preg_match("~^{$pattern}$~", "/{$path}", $matches)) {
                foreach ($matches as $key => $value) {
                    if (is_string($key)) {
                        $this->route_params[$key] = $value;
                    }
                }
                return $route;
            }
        }

        return false;
    }
}