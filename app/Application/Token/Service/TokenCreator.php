<?php

namespace App\Application\Token\Service;

use App\Application\Token\DTO\TokenCreateData;
use App\Application\Token\Exception\TokenValidationException;
use App\Application\Token\Validator\TokenCreateValidator;
use App\Models\Token;

readonly class TokenCreator
{
    public function __construct(
        private TokenCreateValidator $validator,
    ) {}

    /**
     * @throws TokenValidationException
     */
    public function create(TokenCreateData $data): Token
    {
        $this->validator->validate($data);

        return Token::create(
            [
                'api_service_id'       => $data->getApiServiceId(),
                'token_type_id'        => $data->getTokenTypeId(),
                'account_id'           => $data->getAccountId(),
                'token'                => $data->getToken(),
                'period_expiration_at' => $data->getPeriodExpirationAt(),
            ],
        );
    }
}
