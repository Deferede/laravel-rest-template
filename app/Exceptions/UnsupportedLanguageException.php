<?php

namespace App\Exceptions;

use Exception;

class UnsupportedLanguageException extends Exception
{
    public $code = 403;
}
