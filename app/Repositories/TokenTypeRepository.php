<?php

namespace App\Repositories;

use App\Application\TokenType\Repository\TokenTypeRepositoryInterface;
use App\Models\TokenType;

class TokenTypeRepository implements TokenTypeRepositoryInterface
{
    public function getOne(int $id): ?TokenType
    {
        return TokenType::find($id);
    }

    public function getOneByName(string $name): ?TokenType
    {
        return TokenType::query()->where("name", $name)->first();
    }
}
