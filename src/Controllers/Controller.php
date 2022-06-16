<?php

namespace App\Controllers;

use GuzzleHttp\Psr7\Response;
use Psr\Container\ContainerInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

abstract class Controller
{
    public function __construct(protected ContainerInterface $c) {}

    public function __invoke(ServerRequestInterface $req): ResponseInterface
    {
        return new Response(404);
    }
}
