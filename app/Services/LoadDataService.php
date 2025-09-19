<?php

namespace App\Services;

readonly class LoadDataService
{
    public function __construct(
        private GuzzleApiService $apiService,
    ) {}

    /**
     * @throws \Exception
     */
    public function loadAllData(string $endpoint, array $query, callable $saveCallback): void
    {
        $page  = 1;

        do {
            $query['page'] = $page;

            $data  = $this->apiService->get($endpoint, $query);

            $saveCallback($data);

            // если меньше 500, значит последний набор данных
            if (count($data) < 500) {
                break;
            }

            $page++;
        } while (true);
    }
}
