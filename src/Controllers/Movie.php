<?php

namespace App\Controllers;

use App\Core\Router\Route;
use App\Models\API\MovieAPI;
use Psr\Container\ContainerInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class Movie extends Controller
{
    private MovieAPI $api;

    public function __construct (ContainerInterface $c)
    {
        parent::__construct($c);
        $this->api = new MovieAPI();
    }

    #[Route('/movie/[i:id]')]
    public function index (ServerRequestInterface $req): ResponseInterface
    {
        $id = $req->getAttribute('id');
        $movie = $this->api->byID($id);
        $actors = $this->api->getActors($id);

        // Tableau de lien pour chaque catégorie
        $movie->genres = array_map(function ($genre) {
            return "<a href='/movies/$genre->id'>$genre->name</a>";
        }, $movie->genres);

        // Date de sortie au format DateTime
        $movie->release_date = new \DateTime($movie->release_date);

//        dd($movie);
        return $this->render('movie', compact('movie', 'actors'));
    }

    #[Route('/movies/[i:id]')]
    public function list (ServerRequestInterface $req): ResponseInterface
    {
        $id = $req->getAttribute('id');
        $genres = $this->api->getCategories();

        $actual = array_values(array_filter($genres, function ($g) use ($id) {
            return $g->id === (int)$id;
        }))[0] ?? (object)['name' => 'Aucune catégorie séléctionnée', 'id' => null];

        $movies = $this->api->byGenres([$actual->id]);

        return $this->render('movies', compact('movies', 'genres', 'actual'));
    }

    #[Route('/movies')]
    public function all (ServerRequestInterface $req): ResponseInterface
    {
        return $this->list($req);
    }
}
