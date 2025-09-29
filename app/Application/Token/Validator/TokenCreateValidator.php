<?php

namespace App\Application\Token\Validator;

use App\Application\Account\Repository\AccountRepositoryInterface;
use App\Application\ApiService\Repository\ApiServiceRepositoryInterface;
use App\Application\Token\DTO\TokenCreateData;
use App\Application\Token\Exception\TokenValidationException;
use App\Application\TokenType\Repository\TokenTypeRepositoryInterface;

readonly class TokenCreateValidator
{
    public function __construct(
        private AccountRepositoryInterface    $accountRepository,
        private ApiServiceRepositoryInterface $apiServiceRepository,
        private TokenTypeRepositoryInterface  $tokenTypeRepository,
    ) {}

    /**
     * @throws TokenValidationException
     */
    public function validate(TokenCreateData $data): void
    {
        $account = $this->accountRepository->getOne($data->getAccountId());
        if (!$account) {
            throw new TokenValidationException(
                sprintf('Account with ID %s not found', $data->getAccountId()),
                TokenValidationException::TOKEN_ACCOUNT_NOT_FOUND,
            );
        }

        $apiService = $this->apiServiceRepository->getOne($data->getApiServiceId());
        if (!$apiService) {
            throw new TokenValidationException(
                sprintf('Api service with ID %s not found', $data->getApiServiceId()),
                TokenValidationException::TOKEN_API_SERVICE_NOT_FOUND,
            );
        }

        $tokenType = $this->tokenTypeRepository->getOne($data->getTokenTypeId());
        if (!$tokenType) {
            throw new TokenValidationException(
                sprintf('Token type with ID %s not found', $data->getTokenTypeId()),
                TokenValidationException::TOKEN_TOKEN_TYPE_NOT_FOUND,
            );
        }
    }
}
