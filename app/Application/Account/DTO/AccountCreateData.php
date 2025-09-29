<?php

namespace App\Application\Account\DTO;

class AccountCreateData
{
    private int    $companyId;
    private string $name;

    public function getCompanyId(): int
    {
        return $this->companyId;
    }

    public function setCompanyId(int $companyId): static
    {
        $this->companyId = $companyId;

        return $this;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): static
    {
        $this->name = $name;

        return $this;
    }
}
