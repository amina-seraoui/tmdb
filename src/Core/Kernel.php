<?php

namespace App\Core;

use App\Core\Router\Route;
use App\Core\Router\Router;
use DI\ContainerBuilder;
use Psr\Container\ContainerInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;

class Kernel implements RequestHandlerInterface
{
    private array $middlewares = [];
    private ?ContainerInterface $container = null;
    private int $index = 0;

    public function __construct(private string $config)
    {}

    /**
     * Enregistre les routes de chaque controlleur
     * @param string $controller
     * @return $this
     * @throws \Psr\Container\ContainerExceptionInterface
     * @throws \Psr\Container\NotFoundExceptionInterface
     * @throws \ReflectionException
     * @throws \Exception
     */
    public function addController(string $controller): self
    {
        $controller = new \ReflectionClass($controller);
        $container = $this->getContainer();

        /** @var Router $router */
        $router = $container->get(Router::class);

        foreach ($controller->getMethods() as $method) {
            // Récupérer tous les attributs Route
            $attributes = $method->getAttributes(Route::class, \ReflectionAttribute::IS_INSTANCEOF);

            if (empty($attributes)) continue;

            // Ajouter le chemin et le callable au routeur
            foreach ($attributes as $attr) {
                /** @var Route $route */
                $route = $attr->newInstance();
                $router->map($route, $method->getClosure($controller->newInstance($container)));
            }
        }

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
