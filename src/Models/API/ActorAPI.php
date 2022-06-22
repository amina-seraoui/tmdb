<?php

namespace App\Models\API;

class ActorAPI extends TMDB
{
    public function byID (int $id): object
    {
        return $this->callAPI('/person/' . $id);
    }
    public function getCredits (int $id): array
    {
        return $this->callAPI('/person/' . $id . '/combined_credits')->cast;
    }
}
