<?php

namespace App\Models\API;

abstract class TMDB
{
    const URI = 'https://api.themoviedb.org/3';
    const OPTIONS = [
        'api_key' => '3878fff853d2f6476b4bef55a2246bf1',
        'language' => 'fr-FR'
    ];

    /**
     * @param string $endpoint (/!\ Ne doit pas terminer par un /)
     * @param array $options
     * @return object
     * @throws \Exception
     */
    protected function callAPI (string $endpoint, array $options = []): object
    {
        $options = array_merge(self::OPTIONS, $options);
        $curl = curl_init(self::URI . $endpoint . '?' . http_build_query($options));
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

        $content = curl_exec($curl);
        if($content === false) {
            throw new \Exception(curl_error($curl));
        }
        curl_close($curl);

        return json_decode($content);
    }
}
