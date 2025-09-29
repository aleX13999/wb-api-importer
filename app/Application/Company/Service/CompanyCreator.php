<?php

namespace App\Application\Company\Service;

use App\Application\Company\DTO\CompanyCreateData;
use App\Application\Company\Exception\CompanyValidationException;
use App\Application\Company\Validator\CompanyCreateValidator;
use App\Models\Company;

readonly class CompanyCreator
{
    public function __construct(
        private CompanyCreateValidator $validator,
    ) {}

    /**
     * @throws CompanyValidationException
     */
    public function create(CompanyCreateData $data): Company
    {
        $this->validator->validate($data);

        return Company::create(
            [
                'name' => $data->getName(),
            ],
        );
    }
}
