<?php

namespace App\Application\Token\Repository;

use App\Models\Token;
use Illuminate\Database\Eloquent\Collection;

interface TokenRepositoryInterface
{
    public function getOne(int $id): ?Token;
    public function getOneByApiServiceIdAndAccountIdAndTokenTypeId(int $apiServiceId, int $accountId, int $tokenTypeId): ?Token;
    public function getByAccountId(int $accountId): Collection;
}
