<?php

namespace App\Controllers;

use App\Core\Router\Route;
use App\Models\API\ShowAPI;
use Psr\Container\ContainerInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class Show extends Controller
{
    protected string $route_name = 'show';

    public function __construct(ContainerInterface $c, ShowAPI $api)
    {
        parent::__construct($c, $api);
    }

    #[Route('/tv/[i:id]')]
    public function index (ServerRequestInterface $req): ResponseInterface
    {
        $id = $req->getAttribute('id');
        $show = $this->api->byID($id);
        $actors = $this->api->getActors($id);

        // Tableau de lien pour chaque catégorie
        $show->genres = array_map(function ($genre) {
            return "<a href='/shows/$genre->id'>$genre->name</a>";
        }, $show->genres);

        // Récupérer les producteurs
        $show->producers = array_map(function ($prod) {
            return "<a href='/actor/$prod->id'>$prod->name</a>";
        }, $show->created_by);

        // Date de sortie au format DateTime
        $show->first_air_date = new \DateTime($show->first_air_date);

        // Récupérer les teasers ou à défaut les extraits vidéo
        $show->teasers = [...array_filter($show->videos->results, function ($m) {
            return $m->type === 'Teaser';
        })];
        empty($show->teasers) ? $show->teasers = $show->videos->results : null;

        return $this->render('show', compact('show', 'actors', 'producers'));
    }

    #[Route('/shows/[i:id]')]
    public function list (ServerRequestInterface $req): ResponseInterface
    {
        $id = $req->getAttribute('id');
        $genres = $this->api->getCategories();

        $actual = [...array_filter($genres, function ($g) use ($id) {
            return $g->id === (int)$id;
        })][0] ?? (object)['name' => 'Aucune catégorie sélectionnée', 'id' => null];

        [$shows, $total_pages] = $this->api->byGenres([$actual->id]);

        return $this->render('shows', compact('shows', 'genres', 'actual', 'total_pages'));
    }

    #[Route('/shows')]
    public function all (ServerRequestInterface $req): ResponseInterface
    {
        return $this->list($req);
    }
}
