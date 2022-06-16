<?php

namespace App\Core;

use DI\ContainerBuilder;
use Psr\Container\ContainerInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;

class Kernel implements RequestHandlerInterface
{
    private array $controllers = [];
    private array $middlewares = [];
    private ?ContainerInterface $container = null;
    private int $index = 0;

    public function __construct(private string $config)
    {}

    public function addController(string $controller): self
    {
        $this->controllers[] = $controller;
        return $this;
    }

    /**
     * Ajouter un middleware
     * @param string $middleware
     * @return Kernel
     */
    public function pipe(string $middleware): self
    {
        $this->middlewares[] = $middleware;
        return $this;
    }

    public function handle(ServerRequestInterface $req): ResponseInterface
    {
        $middleware = $this->getMiddleware();

        if (is_null($middleware)) {
            throw new \Exception('Aucun middleware n\'a intercepté cette requête.');
        } else if ($middleware instanceof MiddlewareInterface) {
            return $middleware->process($req, $this);
        }
    }

    public function run(ServerRequestInterface $req): ResponseInterface
    {
        return $this->handle($req);
    }

    /**
     * Récupérer le middleware courant ou null
     * @return MiddlewareInterface|null
     * @throws \Psr\Container\ContainerExceptionInterface
     * @throws \Psr\Container\NotFoundExceptionInterface
     */
    public function getMiddleware(): ?MiddlewareInterface
    {
        if (array_key_exists($this->index, $this->middlewares)) {
            $middleware = $this->middlewares[$this->index];

            if (is_string($middleware)) {
                $middleware = $this->getContainer()->get($middleware);
            }
            $this->index++;
            return $middleware;
        }
        return null;
    }

    private function getContainer(): ContainerInterface
    {
        if (is_null($this->container)) {
            $builder = new ContainerBuilder();
            $builder->addDefinitions($this->config);
            $this->container = $builder->build();
        }
        return $this->container;
    }
}
