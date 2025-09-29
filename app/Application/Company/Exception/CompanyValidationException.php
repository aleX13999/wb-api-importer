<?php

namespace App\Application\Company\Exception;

class CompanyValidationException extends \Exception
{
    const COMPANY_NAME_UNIQUE_VIOLATION = 1;
}
