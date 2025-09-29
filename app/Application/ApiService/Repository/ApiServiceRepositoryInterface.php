<?php

namespace App\Application\ApiService\Repository;

use App\Models\ApiService;

interface ApiServiceRepositoryInterface
{
    public function getOne(int $id): ?ApiService;
    public function getOneByName(string $name): ?ApiService;
}
