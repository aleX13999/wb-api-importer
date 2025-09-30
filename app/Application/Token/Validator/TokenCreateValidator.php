<?php

namespace App\Application\Token\Validator;

use App\Application\Account\Repository\AccountRepositoryInterface;
use App\Application\ApiService\Repository\ApiServiceRepositoryInterface;
use App\Application\Token\DTO\TokenCreateData;
use App\Application\Token\Exception\TokenValidationException;
use App\Application\Token\Repository\TokenRepositoryInterface;
use App\Application\TokenType\Repository\TokenTypeRepositoryInterface;

readonly class TokenCreateValidator
{
    public function __construct(
        private AccountRepositoryInterface    $accountRepository,
        private ApiServiceRepositoryInterface $apiServiceRepository,
        private TokenTypeRepositoryInterface  $tokenTypeRepository,
        private TokenRepositoryInterface      $tokenRepository,
    ) {}

    /**
     * @throws TokenValidationException
     */
    public function validate(TokenCreateData $data): void
    {
        $accountId    = $data->getAccountId();
        $apiServiceId = $data->getApiServiceId();
        $tokenTypeId  = $data->getTokenTypeId();

        $account = $this->accountRepository->getOne($accountId);
        if (!$account) {
            throw new TokenValidationException(
                sprintf('Account with ID %s not found', $accountId),
                TokenValidationException::TOKEN_ACCOUNT_NOT_FOUND,
            );
        }

        $apiService = $this->apiServiceRepository->getOne($apiServiceId);
        if (!$apiService) {
            throw new TokenValidationException(
                sprintf('Api service with ID %s not found', $apiServiceId),
                TokenValidationException::TOKEN_API_SERVICE_NOT_FOUND,
            );
        }

        $tokenType = $this->tokenTypeRepository->getOne($tokenTypeId);
        if (!$tokenType) {
            throw new TokenValidationException(
                sprintf('Token type with ID %s not found', $tokenTypeId),
                TokenValidationException::TOKEN_TOKEN_TYPE_NOT_FOUND,
            );
        }

        $token = $this->tokenRepository->getOneByApiServiceIdAndAccountIdAndTokenTypeId($apiServiceId, $accountId, $tokenTypeId);
        if ($token) {
            throw new TokenValidationException(
                sprintf(
                    'Token with accountId - %s, apiServiceId - %S, tokenType - %s already exists',
                    $accountId,
                    $apiServiceId,
                    $tokenTypeId,
                ),
                TokenValidationException::TOKEN_VIOLATION_ERROR,
            );
        }
    }
}
