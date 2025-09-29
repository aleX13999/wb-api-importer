<?php

namespace App\Application\Token\DTO;

use DateTime;

class TokenCreateData
{
    private int      $accountId;
    private int      $apiServiceId;
    private int      $tokenTypeId;
    private string   $token;
    private DateTime $periodExpirationAt;

    public function getAccountId(): int
    {
        return $this->accountId;
    }

    public function setAccountId(int $accountId): static
    {
        $this->accountId = $accountId;

        return $this;
    }

    public function getApiServiceId(): int
    {
        return $this->apiServiceId;
    }

    public function setApiServiceId(int $apiServiceId): static
    {
        $this->apiServiceId = $apiServiceId;

        return $this;
    }

    public function getTokenTypeId(): int
    {
        return $this->tokenTypeId;
    }

    public function setTokenTypeId(int $tokenTypeId): static
    {
        $this->tokenTypeId = $tokenTypeId;

        return $this;
    }

    public function getToken(): string
    {
        return $this->token;
    }

    public function setToken(string $token): static
    {
        $this->token = $token;

        return $this;
    }

    public function getPeriodExpirationAt(): DateTime
    {
        return $this->periodExpirationAt;
    }

    public function setPeriodExpirationAt(DateTime $periodExpirationAt): static
    {
        $this->periodExpirationAt = $periodExpirationAt;

        return $this;
    }
}
