<?php

namespace Src;

use FastRoute\RouteCollector;
use FastRoute\RouteParser\Std;
use FastRoute\DataGenerator\MarkBased;
use FastRoute\Dispatcher\MarkBased as Dispatcher;
use Src\Traits\SingletonTrait;
use function Collect\collection;

class Middleware
{
    use SingletonTrait;

    private RouteCollector $middlewareCollector;

    public function add($httpMethod, string $route, array $action): void
    {
        $this->middlewareCollector->addRoute($httpMethod, $route, $action);
    }

    public function group(string $prefix, callable $callback): void
    {
        $this->middlewareCollector->addGroup($prefix, $callback);
    }

    private function __construct()
    {
        $this->middlewareCollector = new RouteCollector(new Std(), new MarkBased());
    }

    private function getMiddlewaresForRoute(string $httpMethod, string $uri): array
    {
        $dispatcherMiddleware = new Dispatcher($this->middlewareCollector->getData());
        return $dispatcherMiddleware->dispatch($httpMethod, $uri)[1] ?? [];
    }

    public function go(string $httpMethod, string $uri, Request $request): Request
    {
        return $this->runMiddlewares($httpMethod, $uri, $this->runAppMiddlewares($request));
    }

    private function runMiddlewares(string $httpMethod, string $uri, Request $request): Request
    {
        $routeMiddleware = app()->settings->app['routeMiddleware'];

        foreach ($this->getMiddlewaresForRoute($httpMethod, $uri) as $middleware) {
            $args = explode(':', $middleware);
            $request = (new $routeMiddleware[$args[0]])->handle($request, $args[1]?? null) ?? $request;
        }
        return $request;
    }

    private function runAppMiddlewares(Request $request): Request
    {
        $routeMiddleware = app()->settings->app['routeAppMiddleware'];

        collection($routeMiddleware)->each(function ($value, $key, $request) {
            $args = explode(':', $key);
            $request = (new $value)->handle($request, $args[1] ?? null) ?? $request;
        }, $request);
        return $request;
    }
}

