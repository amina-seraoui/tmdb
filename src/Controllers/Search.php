<?php

namespace App\Controllers;

use App\Core\Router\Route;
use App\Models\API\MovieAPI;
use Psr\Container\ContainerInterface;
use Psr\Http\Message\ServerRequestInterface;

class Search extends Controller
{
    protected string $route_name = 'search';
    private MovieAPI $api;

    public function __construct(ContainerInterface $c)
    {
        parent::__construct($c);
        $this->api = new MovieAPI();
    }

    #[Route('/search')]
    public function index (ServerRequestInterface $req)
    {
        $movies = $this->api->getTrends('movie');
        $shows = $this->api->getTrends('tv');
        $actors = $this->api->getTrends('person');

        return $this->render('search', compact('movies', 'shows', 'actors'));
    }
}
