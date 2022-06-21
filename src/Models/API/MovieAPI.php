<?php

namespace App\Models\API;

class MovieAPI extends TMDB
{
    public function getCategories (): array
    {
        return $this->callAPI('/genre/movie/list')->genres;
    }
    public function getTrends (): array
    {
        return $this->callAPI('/trending/all/day')->results;
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
    public function getImagesByID (int $id): object
    {
        return $this->callAPI('/movie/' . $id . '/images', [
            'include_image_language' => 'fr',
            'include_video_language' => 'fr'
        ]);
    }
}
