<?php

namespace App\Application\TokenType\Validator;

use App\Application\TokenType\DTO\TokenTypeCreateData;
use App\Application\TokenType\Exception\TokenTypeValidationException;
use App\Application\TokenType\Repository\TokenTypeRepositoryInterface;

readonly class TokenTypeCreateValidator
{
    public function __construct(
        private TokenTypeRepositoryInterface $repository,
    ) {}

    /**
     * @throws TokenTypeValidationException
     */
    public function validate(TokenTypeCreateData $data): void
    {
        $tokenType = $this->repository->getOneByName($data->getName());
        if ($tokenType) {
            throw new TokenTypeValidationException(
                sprintf('Token type with name %s already exists!', $data->getName()),
                TokenTypeValidationException::TOKEN_TYPE_NAME_UNIQUE_VIOLATION,
            );
        }
    }
}
