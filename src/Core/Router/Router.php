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

    public function match(ServerRequestInterface $req): ?ResponseInterface
    {
        if ($route = $this->router->match($req->getUri()->getPath(), $req->getMethod())) {
            $params = $route['params'];

            // Parcourir les paramètres de la route et les ajouter en tant qu'attribut de la requête
            $req = array_reduce(array_keys($params), function ($req, $key) use ($params) {
                return $req->withAttribute($key, $params[$key]);
            }, $req);

            return call_user_func_array($route['target'], [$req]);
        }

        return null;
    }
}
