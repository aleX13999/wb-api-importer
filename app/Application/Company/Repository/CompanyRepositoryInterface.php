<?php

namespace App\Application\Company\Repository;

use App\Models\Company;

interface CompanyRepositoryInterface
{
    public function getOne(int $id): ?Company;
    public function getOneByName(string $name): ?Company;
}
