<?php

namespace App\Application\Account\Exception;

class AccountValidationException extends \Exception
{
    const ACCOUNT_COMPANY_ID_NOT_FOUND  = 1;
    const ACCOUNT_NAME_UNIQUE_VIOLATION = 2;
}
