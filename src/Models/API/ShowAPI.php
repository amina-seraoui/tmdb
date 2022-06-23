<?php

namespace App\Models\API;

class ShowAPI extends TMDB
{
    public function getCategories (): array
    {
        return $this->callAPI('/genre/tv/list')->genres;
    }
    public function byID (int $id): object
    {
        return $this->callAPI('/tv/' . $id, [
            'append_to_response' => 'videos,images',
            'include_image_language' => 'fr',
            'include_video_language' => 'fr'
        ]);
    }
    public function getActors (int $id): array
    {
        return $this->callAPI('/tv/' . $id . '/credits')->cast;
    }
    public function byGenres (array $genres, int $page = 1): array
    {
        $res = $this->callAPI('/discover/tv', [
            'with_genres' => implode($genres),
            'page' => $page
        ]);
        return [$res->results, $res->total_pages];
    }
}
