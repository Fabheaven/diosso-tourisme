<?php
// src/Service/OpenSkyService.php

namespace App\Service;

use GuzzleHttp\Client;

class OpenSkyService
{
    private $client;

    public function __construct()
    {
        $this->client = new Client([
            'base_uri' => 'https://opensky-network.org/api/', // Base URI de l'API OpenSky
        ]);
    }

    public function getDepartures(string $airport, int $begin, int $end): array
    {
        $response = $this->client->request('GET', 'flights/departure', [
            'query' => [
                'airport' => $airport,
                'begin' => $begin,
                'end' => $end
            ]
        ]);
        return json_decode($response->getBody()->getContents(), true);
    }

    public function getArrivals(string $airport, int $begin, int $end): array
    {
        $response = $this->client->request('GET', 'flights/arrival', [
            'query' => [
                'airport' => $airport,
                'begin' => $begin,
                'end' => $end
            ]
        ]);
        return json_decode($response->getBody()->getContents(), true);
    }
}
