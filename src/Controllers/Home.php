<?php

namespace App\Controllers;

use App\Core\Router\Route;
use App\Models\API\MovieAPI;
use Psr\Container\ContainerInterface;
use Psr\Http\Message\ServerRequestInterface;

class Home extends Controller
{
    private MovieAPI $api;

    public function __construct(ContainerInterface $c)
    {
        parent::__construct($c);
        $this->api = new MovieAPI();
    }

    #[Route('/')]
    public function index (ServerRequestInterface $req)
    {
        $categories = $this->api->getCategories();
        $trends = $this->api->getTrends('movie');
        $movie = $this->api->byID($trends[0]->id);

        // Récupérer les teasers ou à défaut les extraits vidéo
        $movie->teasers = [...array_filter($movie->videos->results, function ($m) {
            return $m->type === 'Teaser';
        })];
        empty($movie->teasers) ? $movie->teasers = $movie->videos->results : null;

        return $this->render('home', compact('categories', 'trends', 'movie'));
    }
}
