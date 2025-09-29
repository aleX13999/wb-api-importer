<?php

namespace App\Application\ApiService\Service;

use App\Application\ApiService\DTO\ApiServiceCreateData;
use App\Application\ApiService\Exception\ApiServiceValidationException;
use App\Application\ApiService\Validator\ApiServiceCreateValidator;
use App\Models\ApiService;

readonly class ApiServiceCreator
{
    public function __construct(
        private ApiServiceCreateValidator $validator,
    ) {}

    /**
     * @throws ApiServiceValidationException
     */
    public function create(ApiServiceCreateData $data): ApiService
    {
        $this->validator->validate($data);

        return ApiService::create(
            [
                'name' => $data->getName(),
            ],
        );
    }
}
