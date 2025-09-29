<?php

namespace App\Repositories;

use App\Application\Token\Repository\TokenRepositoryInterface;
use App\Models\Token;
use Illuminate\Database\Eloquent\Collection;

class TokenRepository implements TokenRepositoryInterface
{
    public function getOne(int $id): ?Token
    {
        return Token::find($id);
    }

    public function getOneByApiServiceIdAndAccountIdAndTokenTypeId(int $apiServiceId, int $accountId, int $tokenTypeId): ?Token
    {
        return Token::query()
            ->with(['apiService', 'account', 'tokenType'])
            ->where('api_service_id', $apiServiceId)
            ->where('account_id', $accountId)
            ->where('token_type_id', $tokenTypeId)
            ->first();
    }

    public function getByAccountId(int $accountId): Collection
    {
        return Token::query()
            ->with(['apiService', 'account', 'tokenType'])
            ->where('account_id', $accountId)
            ->get();
    }
}
