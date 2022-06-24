<?php

namespace App\Controllers;

use App\Core\Router\Renderer;
use GuzzleHttp\Psr7\Response;
use Psr\Container\ContainerInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

abstract class Controller
{
    protected string $route_name = '';
    private Renderer $renderer;

    public function __construct(protected ContainerInterface $c) {
        $this->renderer = $c->get(Renderer::class);
    }

    public function __invoke(ServerRequestInterface $req): ResponseInterface
    {
        return new Response(404);
    }

    protected function render(string $view, array $params = []): ResponseInterface
    {
        try {
            $body = $this->renderer->render($view, array_merge([
                'route_name' => $this->route_name
            ], $params));
            return new Response(200, [], $body);
        } catch (\Exception $e) {
            return new Response(500, [], 'Chemin innaccessible.');
        }
    }
}
