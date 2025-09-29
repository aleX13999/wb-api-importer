<?php

namespace App\Application\Account\Repository;

use App\Models\Account;
use Illuminate\Database\Eloquent\Collection;

interface AccountRepositoryInterface
{
    public function getOne(int $id): ?Account;
    public function getOneByName(string $name): ?Account;
    public function getAll(): Collection;
}
