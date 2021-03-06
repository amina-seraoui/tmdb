<?php

namespace App\Models\API;

use Psr\Container\ContainerInterface;

abstract class TMDB
{
    public const URI = 'https://api.themoviedb.org/3';
    public const OPTIONS = [
        'language' => 'fr-FR'
    ];

    public function __construct(private ContainerInterface $c)
    {}

    /**
     * Effectue un appel curl à l'API TMDB et renvoie un objet
     * @param string $endpoint (/!\ Ne doit pas terminer par un /)
     * @param array $options
     * @return object
     * @throws \Exception
     */
    protected function callAPI (string $endpoint, array $options = []): object
    {
        $options = array_merge(self::OPTIONS, $options, ['api_key' => $this->c->get('API_KEY')]);
        $curl = curl_init(self::URI . $endpoint . '?' . http_build_query($options));
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

        $content = curl_exec($curl);
        if($content === false) {
            throw new \Exception(curl_error($curl));
        }
        curl_close($curl);

        return json_decode($content);
    }

    /**
     * Renvoie les tendances selon le type de contenu voulu
     * @param string $type 'movie' | 'tv' | 'person'
     * @param int $page
     * @return array
     * @throws \Exception
     */
    public function getTrends (string $type, int $page = 1): array
    {
        return $this->callAPI('/trending/' . $type . '/day', ['page' => $page])->results;
    }
}
