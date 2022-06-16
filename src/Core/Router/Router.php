<?php

namespace App\Core\Router;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class Router
{
    private \AltoRouter $router;

    public function __construct()
    {
        $this->router = new \AltoRouter();
    }

    /**
     * @throws \Exception
     */
    public function map(Route $route, $callable): self
    {
        $this->router->map($route->getMethod(), $route->getPath(), $callable, $route->getName());
        return $this;
    }

    public function match(ServerRequestInterface $req): ?string
    {
        if ($route = $this->router->match($req->getUri()->getPath(), $req->getMethod())) {
//            return $route['target'];
            return call_user_func_array($route['target'], [$req]);
        }

        return null;
    }
}
