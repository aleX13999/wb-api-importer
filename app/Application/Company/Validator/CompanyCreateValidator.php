<?php

namespace App\Application\Company\Validator;

use App\Application\Company\DTO\CompanyCreateData;
use App\Application\Company\Exception\CompanyValidationException;
use App\Application\Company\Repository\CompanyRepositoryInterface;

readonly class CompanyCreateValidator
{
    public function __construct(
        private CompanyRepositoryInterface $repository,
    ) {}

    /**
     * @throws CompanyValidationException
     */
    public function validate(CompanyCreateData $data): void
    {
        $company = $this->repository->getOneByName($data->getName());
        if ($company) {
            throw new CompanyValidationException(
                sprintf('Company with name %s already exists!', $data->getName()),
                CompanyValidationException::COMPANY_NAME_UNIQUE_VIOLATION,
            );
        }
    }
}
