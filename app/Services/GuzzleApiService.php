<?php

namespace App\Services;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;

class GuzzleApiService
{
    private Client $client;
    private string $apiKey;

    public function __construct()
    {
        $this->apiKey = env('WB_API_KEY');
        $this->client = new Client(
            [
                'base_uri' => sprintf('http://%s:%s/api/', env('WB_API_HOST'), env('WB_API_PORT')),
                'curl' => [
                    CURLOPT_SSLVERSION => CURL_SSLVERSION_TLSv1_2, // форсируем TLS 1.2
                ],
            ]
        );
    }

    /**
     * @throws \Exception
     */
    public function get(string $endpoint, array $query = []): array
    {
        try {
            $query['key'] = $this->apiKey;

            $response = $this->client->request('GET', $endpoint, ['query' => $query]);

            if ($response->getStatusCode() === 200) {
                $contents = $response->getBody()->getContents();
                $responseArray = json_decode($contents, true);
                return $responseArray['data'] ?? [];
            }

            return [];

        } catch (GuzzleException $e) {
            throw new \Exception($e->getMessage());
        }
    }
}
