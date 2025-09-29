<?php

namespace App\Application\TokenType\Exception;

class TokenTypeValidationException extends \Exception
{
    const TOKEN_TYPE_NAME_UNIQUE_VIOLATION = 1;
}
