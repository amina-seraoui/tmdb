<?php

namespace App\Controllers;

use App\Core\Router\Route;
use App\Models\API\ActorAPI;
use App\Models\API\TMDB;
use Psr\Container\ContainerInterface;
use Psr\Http\Message\ServerRequestInterface;

class Actor extends Controller
{
    protected string $route_name = 'actor';
    private TMDB $api;

    public function __construct(ContainerInterface $c)
    {
        parent::__construct($c);
        $this->api = new ActorAPI();
    }

    #[Route('/actor/[i:id]')]
    public function index (ServerRequestInterface $req)
    {
        $id = $req->getAttribute('id');
        $actor = $this->api->byID($id);
        $movies = $this->api->getCredits($id);

        // Transformer les dates de sortie en DateTime
        $movies = array_map(function ($m) {
            $m->release_date = $m->media_type === 'tv' ? new \DateTime($m->first_air_date) : new \DateTime($m->release_date);
            return $m;
        }, $movies);

        // Trier les films dans l'ordre de sortie croissant
        usort($movies, function($a, $b) {
            return $a->release_date < $b->release_date;
        });

        $populars = $movies;

        // Trier les films les plus populaires
        usort($populars, function($a, $b) {
            return $a->popularity < $b->popularity;
        });

        // Date de naissance au format DateTime
        $actor->birthday = new \DateTime($actor->birthday);
        $actor->age = date_diff($actor->birthday, date_create('now'))->y;

        return $this->render('actor', compact('actor', 'movies', 'populars'));
    }
}
