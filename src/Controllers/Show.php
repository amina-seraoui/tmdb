<?php

namespace App\Controllers;

use App\Core\Router\Route;
use App\Models\API\ShowAPI;
use Psr\Container\ContainerInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class Show extends Controller
{
    private ShowAPI $api;

    public function __construct(ContainerInterface $c)
    {
        parent::__construct($c);
        $this->api = new ShowAPI();
    }

    #[Route('/tv/[i:id]')]
    public function index (ServerRequestInterface $req)
    {
        $id = $req->getAttribute('id');
        $show = $this->api->byID($id);
        $actors = $this->api->getActors($id);

        //
        // Tableau de lien pour chaque catégorie
        $show->genres = array_map(function ($genre) {
            return "<a href='/shows/$genre->id'>$genre->name</a>";
        }, $show->genres);

        // Date de sortie au format DateTime
        $show->first_air_date = new \DateTime($show->first_air_date);

        return $this->render('show', compact('show', 'actors'));
    }

    #[Route('/shows/[i:id]')]
    public function list (ServerRequestInterface $req): ResponseInterface
    {
        $id = $req->getAttribute('id');
        $genres = $this->api->getCategories();

        $actual = array_values(array_filter($genres, function ($g) use ($id) {
            return $g->id === (int)$id;
        }))[0] ?? (object)['name' => 'Aucune catégorie séléctionnée', 'id' => null];

        $shows = $this->api->byGenres([$actual->id]);

        return $this->render('shows', compact('shows', 'genres', 'actual'));
    }

    #[Route('/shows')]
    public function all (ServerRequestInterface $req): ResponseInterface
    {
        return $this->list($req);
    }
}
