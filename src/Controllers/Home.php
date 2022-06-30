<?php

namespace App\Controllers;

use App\Core\Router\Route;
use App\Models\API\MovieAPI;
use Psr\Container\ContainerInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class Home extends Controller
{
    public function __construct(ContainerInterface $c, MovieAPI $api)
    {
        parent::__construct($c, $api);
    }

    #[Route('/')]
    public function index (ServerRequestInterface $req): ResponseInterface
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
