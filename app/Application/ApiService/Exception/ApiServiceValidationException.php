<?php

namespace App\Application\ApiService\Exception;

class ApiServiceValidationException extends \Exception
{
    const API_SERVICE_NAME_UNIQUE_VIOLATION = 1;
}
