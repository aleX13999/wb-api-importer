<?php

namespace App\Repositories;

use App\Application\ApiService\Repository\ApiServiceRepositoryInterface;
use App\Models\ApiService;

class ApiServiceRepository implements ApiServiceRepositoryInterface
{
    public function getOne(int $id): ?ApiService
    {
        return ApiService::find($id);
    }

    public function getOneByName(string $name): ?ApiService
    {
        return ApiService::query()->where("name", $name)->first();
    }
}
