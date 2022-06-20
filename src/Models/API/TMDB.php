<?php

namespace App\Models\API;

abstract class TMDB
{
    const URI = 'https://api.themoviedb.org/3';
    const OPTIONS = [
        'api_key' => '3878fff853d2f6476b4bef55a2246bf1',
        'language' => 'fr-FR'
    ];

    protected function callAPI (string $endpoint): object
    {
        $curl = curl_init(self::URI . $endpoint . '?' . http_build_query(self::OPTIONS));
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

        $content = curl_exec($curl);
        if($content === false) {
            throw new \Exception(curl_error($curl));
        }
        curl_close($curl);
        return json_decode($content);
    }
}
