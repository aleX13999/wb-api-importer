<?php

namespace App\Application\Token\Exception;

class TokenValidationException extends \Exception
{
    const TOKEN_ACCOUNT_NOT_FOUND     = 1;
    const TOKEN_API_SERVICE_NOT_FOUND = 2;
    const TOKEN_TOKEN_TYPE_NOT_FOUND  = 3;
}
