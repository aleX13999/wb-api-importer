<?php

namespace App\Application\TokenType\Service;

use App\Application\TokenType\DTO\TokenTypeCreateData;
use App\Application\TokenType\Exception\TokenTypeValidationException;
use App\Application\TokenType\Validator\TokenTypeCreateValidator;
use App\Models\TokenType;

readonly class TokenTypeCreator
{
    public function __construct(
        private TokenTypeCreateValidator $validator,
    ) {}

    /**
     * @throws TokenTypeValidationException
     */
    public function create(TokenTypeCreateData $data): TokenType
    {
        $this->validator->validate($data);

        return TokenType::create(
            [
                'name' => $data->getName(),
            ],
        );
    }
}
