<?php

namespace App\Application\ApiService\Validator;

use App\Application\ApiService\DTO\ApiServiceCreateData;
use App\Application\ApiService\Exception\ApiServiceValidationException;
use App\Application\ApiService\Repository\ApiServiceRepositoryInterface;

readonly class ApiServiceCreateValidator
{
    public function __construct(
        private ApiServiceRepositoryInterface $repository,
    ) {}

    /**
     * @throws ApiServiceValidationException
     */
    public function validate(ApiServiceCreateData $data): void
    {
        $apiService = $this->repository->getOneByName($data->getName());
        if ($apiService) {
            throw new ApiServiceValidationException(
                sprintf('API service with name %s already exists!', $data->getName()),
                ApiServiceValidationException::API_SERVICE_NAME_UNIQUE_VIOLATION,
            );
        }
    }
}
