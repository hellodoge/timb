<?php

namespace repository\exceptions;

use Exception;
use Throwable;

class FailedReadingQueryException extends Exception
{
    const MESSAGE = "Cannot read query";

    public function __construct($message = self::MESSAGE, $code = 0, Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}