<?php

namespace App\Controllers;

use App\Core\Router\Route;
use App\Models\API\MovieAPI;
use Psr\Container\ContainerInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class Movie extends Controller
{
    protected string $route_name = 'movie';

    public function __construct (ContainerInterface $c, MovieAPI $api)
    {
        parent::__construct($c, $api);
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

        // Récupérer les producteurs
        $movie->producers = array_map(function ($prod) {
            return "<a href='/actor/$prod->id'>$prod->name</a>";
        }, $this->api->getProducers($id));

        // Date de sortie au format DateTime
        $movie->release_date = new \DateTime($movie->release_date);

        // Récupérer les teasers ou à défaut les extraits vidéo
        $movie->teasers = [...array_filter($movie->videos->results, function ($m) {
                return $m->type === 'Teaser';
        })];
        empty($movie->teasers) ? $movie->teasers = $movie->videos->results : null;
        $movie->runtime = $this->minutesToHours($movie->runtime ?? 0);

        return $this->render('movie', compact('movie', 'actors'));
    }

    #[Route('/movies/[i:id]')]
    public function list (ServerRequestInterface $req): ResponseInterface
    {
        $id = $req->getAttribute('id');
        $genres = $this->api->getCategories();

        $actual = [...array_filter($genres, function ($g) use ($id) {
            return $g->id === (int)$id;
        })][0] ?? (object)['name' => 'Aucune catégorie sélectionnée', 'id' => null];

        [$movies, $total_pages] = $this->api->byGenres([$actual->id]);

        return $this->render('movies', compact('movies', 'genres', 'actual', 'total_pages'));
    }

    #[Route('/movies')]
    public function all (ServerRequestInterface $req): ResponseInterface
    {
        return $this->list($req);
    }

    /**
     * Renvoie un temps en minutes au format '0h00'
     * @param int $min
     * @return string
     */
    private function minutesToHours(int $min): string
    {
        $hours = floor($min / 60);
        $minutes = ($min % 60);
        return sprintf('%2dh%02d', $hours, $minutes);
    }
}
