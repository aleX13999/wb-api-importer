<?php

namespace App\Application\Account\Repository;

use App\Models\Account;

interface AccountRepositoryInterface
{
    public function getOne(int $id): ?Account;
    public function getOneByName(string $name): ?Account;
}
