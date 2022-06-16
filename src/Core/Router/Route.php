<?php

namespace App\Core\Router;

#[\Attribute(\Attribute::TARGET_METHOD|\Attribute::TARGET_CLASS)]
class Route {
    public function __construct(private string $path, private string $method = 'GET', private string $name = '') {}

    public function getPath(): string
    {
        return $this->path;
    }

    public function getMethod(): string
    {
        return $this->method;
    }

    public function getName(): string
    {
        return $this->name;
    }
}
