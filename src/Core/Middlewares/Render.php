<?php

namespace App\Core\Middlewares;

use App\Core\Router\Router;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;

class Render implements MiddlewareInterface
{
    public function __construct(private Router $router) {}

    /**
     * Si l'url match : affiche la page HTML, sinon : passe au middleware suivant
     * @param ServerRequestInterface $request
     * @param RequestHandlerInterface $handler
     * @return ResponseInterface
     */
    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
        return $this->router->match($request) ?? $handler->handle($request);
    }
}
