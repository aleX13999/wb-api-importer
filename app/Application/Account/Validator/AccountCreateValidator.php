<?php

namespace App\Application\Account\Validator;

use App\Application\Account\DTO\AccountCreateData;
use App\Application\Account\Exception\AccountValidationException;
use App\Application\Account\Repository\AccountRepositoryInterface;
use App\Application\Company\Repository\CompanyRepositoryInterface;

readonly class AccountCreateValidator
{
    public function __construct(
        private CompanyRepositoryInterface $companyRepository,
        private AccountRepositoryInterface $accountRepository,
    ) {}

    /**
     * @throws AccountValidationException
     */
    public function validate(AccountCreateData $data): void
    {
        $company = $this->companyRepository->getOne($data->getCompanyId());
        if (!$company) {
            throw new AccountValidationException(
                sprintf('Company with ID %s not found', $data->getCompanyId()),
                AccountValidationException::ACCOUNT_COMPANY_ID_NOT_FOUND,
            );
        }

        $account = $this->accountRepository->getOneByName($data->getName());
        if ($account) {
            throw new AccountValidationException(
                sprintf('Account with name %s already exists!', $data->getName()),
                AccountValidationException::ACCOUNT_NAME_UNIQUE_VIOLATION,
            );
        }
    }
}
