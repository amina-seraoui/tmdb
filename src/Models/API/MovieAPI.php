<?php

namespace App\Models\API;

class MovieAPI extends TMDB
{
    public function getCategories (): array
    {
        return $this->callAPI('/genre/movie/list')->genres;
    }
    public function getTrends (int $page = 1): array
    {
        return $this->callAPI('/trending/all/day', ['page' => $page])->results;
    }
    public function byID (int $id): object
    {
        return $this->callAPI('/movie/' . $id, [
            'append_to_response' => 'videos,images',
            'include_image_language' => 'fr',
            'include_video_language' => 'fr'
        ]);
    }
    public function getActors (int $id): array
    {
        return $this->callAPI('/movie/' . $id . '/credits')->cast;
    }
    public function byGenres (array $genres, int $page = 1): array
    {
        $res = $this->callAPI('/discover/movie', [
            'with_genres' => implode($genres),
            'page' => $page
        ]);

        return [$res->results, $res->total_pages];
    }
}
