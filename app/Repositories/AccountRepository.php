<?php

namespace App\Repositories;

use App\Application\Account\Repository\AccountRepositoryInterface;
use App\Models\Account;

class AccountRepository implements AccountRepositoryInterface
{
    public function getOne(int $id): ?Account
    {
        return Account::find($id);
    }

    public function getOneByName(string $name): ?Account
    {
        return Account::query()->where('name', $name)->first();
    }
}
