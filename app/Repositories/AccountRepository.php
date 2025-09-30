<?php

namespace App\Repositories;

use App\Application\Account\Repository\AccountRepositoryInterface;
use App\Models\Account;
use Illuminate\Database\Eloquent\Collection;

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

    public function getAll(): Collection
    {
        return Account::all();
    }

    public function getByIds(array $ids): Collection
    {
        return Account::query()->whereIn('id', $ids)->get();
    }
}
