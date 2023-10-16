<?php

namespace App\Exceptions;

use Exception;

class AiException extends Exception
{
    public static function unknownException(): self
    {
        return new self('Unknown AI exception');
    }
}
