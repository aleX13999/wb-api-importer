<?php

namespace App\Services;

use App\Exceptions\ImportDataException;
use GuzzleHttp\Exception\ClientException;

readonly class LoadDataService
{
    public function __construct(
        private GuzzleApiService $apiService,
    ) {}

    /**
     * @throws ImportDataException
     * @throws \Exception
     */
    public function loadAllData(string $endpoint, array $query, callable $saveCallback, int $maxRetries = 5): void
    {
        $page = 1;

        do {
            $query['page'] = $page;
            $attempt = 0;

            do {
                try {
                    $data = $this->apiService->get($endpoint, $query);
                    break; // если успешно - выходим из цикла попыток

                } catch (ClientException $e) {
                    $response = $e->getResponse();
                    if ($response->getStatusCode() == 429) {
                        $attempt++;
                        $wait = pow(2, $attempt);
                        sleep($wait);

                        if ($attempt >= $maxRetries) {
                            throw new ImportDataException("Max retries reached for 429 Too Many Requests.");
                        }

                    } else {
                        throw $e;
                    }
                }
            } while (true);

            $saveCallback($data);

            if (count($data) < 500) {
                break;
            }

            $page++;
        } while (true);
    }
}
