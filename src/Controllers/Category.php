<?php

namespace App\Controllers;

use App\Core\Router\Route;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class Category extends Controller
{
    #[Route('/c')]
    public function index (ServerRequestInterface $req)
    {
        return 'cat';
    }
}
