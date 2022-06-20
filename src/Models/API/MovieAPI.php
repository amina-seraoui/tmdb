<?php

namespace App\Models\API;

class MovieAPI extends TMDB
{
    /**
     * @throws \Exception
     */
    public function getCategories (): array
    {
        return $this->callAPI('/genre/movie/list')->genres;
    }

    /**
     * @throws \Exception
     */
    public function getTrends (): array
    {
        return $this->callAPI('/trending/all/day')->results;
    }
    public function byID (int $id): array
    {

        return [];
    }
}
