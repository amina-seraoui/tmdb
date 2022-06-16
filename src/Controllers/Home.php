<?php

namespace App\Controllers;

use App\Core\Router\Route;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class Home extends Controller
{
    #[Route('/')]
    public function index (ServerRequestInterface $req)
    {
        return $this->render('home');
    }
}
