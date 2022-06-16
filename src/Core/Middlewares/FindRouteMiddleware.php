<?php

namespace App\Core\Middlewares;

use App\Core\Router\Router;
use GuzzleHttp\Psr7\Response;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;

class FindRouteMiddleware implements MiddlewareInterface
{
    public function __construct(private Router $router) {}

    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
        return $this->router->match($request) ?? $handler->handle($request);
    }
}
