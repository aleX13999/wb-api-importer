<?php

namespace App\Repositories;

use App\Application\Company\Repository\CompanyRepositoryInterface;
use App\Models\Company;

class CompanyRepository implements CompanyRepositoryInterface
{
    public function getOne(int $id): ?Company
    {
        return Company::find($id);
    }

    public function getOneByName(string $name): ?Company
    {
        return Company::query()->where('name', $name)->first();
    }
}
