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
        $categories = $this->getCategories();
        $trends = $this->getTrends();
//        dd($trends);
        return $this->render('home', compact('categories', 'trends'));
    }

    private function getCategories(): array
    {
        $options = [
            'api_key' => '3878fff853d2f6476b4bef55a2246bf1',
            'language' => 'fr-FR'
        ];
        $curl = curl_init('https://api.themoviedb.org/3/genre/movie/list?' . http_build_query($options));
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

        $content = curl_exec($curl);
        if($content === false) {
            throw new \Exception(curl_error($curl));
        }
        curl_close($curl);
        return json_decode($content)->genres;
    }

    private function getTrends()
    {
        $options = [
            'api_key' => '3878fff853d2f6476b4bef55a2246bf1',
            'language' => 'fr-FR'
        ];
        $curl = curl_init('https://api.themoviedb.org/3/trending/all/day?' . http_build_query($options));
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

        $content = curl_exec($curl);
        if($content === false) {
            throw new \Exception(curl_error($curl));
        }
        curl_close($curl);
        return json_decode($content)->results;
    }
}
