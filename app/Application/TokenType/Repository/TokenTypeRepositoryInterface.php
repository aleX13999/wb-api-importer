<?php

namespace App\Application\TokenType\Repository;

use App\Models\TokenType;

interface TokenTypeRepositoryInterface
{
    public function getOne(int $id): ?TokenType;
    public function getOneByName(string $name): ?TokenType;
}
