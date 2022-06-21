<?php

namespace App\Controllers;

use App\Core\Router\Route;
use App\Models\API\ShowAPI;
use Psr\Container\ContainerInterface;
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
            return "<a href='/tv/$genre->id'>$genre->name</a>";
        }, $show->genres);

        // Date de sortie au format DateTime
        $show->first_air_date = new \DateTime($show->first_air_date);

//        dd($movie);
        return $this->render('show', compact('show', 'actors'));
    }
}
