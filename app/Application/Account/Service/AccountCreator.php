<?php

namespace App\Application\Account\Service;

use App\Application\Account\DTO\AccountCreateData;
use App\Application\Account\Exception\AccountValidationException;
use App\Application\Account\Validator\AccountCreateValidator;
use App\Models\Account;

readonly class AccountCreator
{
    public function __construct(
        private AccountCreateValidator $validator,
    ) {}

    /**
     * @throws AccountValidationException
     */
    public function create(AccountCreateData $data): Account
    {
        $this->validator->validate($data);

        return Account::create(
            [
                'company_id' => $data->getCompanyId(),
                'name'       => $data->getName(),
            ],
        );
    }
}
