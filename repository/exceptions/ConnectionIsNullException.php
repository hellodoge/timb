<?php

namespace repository\exceptions;

use Exception;
use Throwable;

class ConnectionIsNullException extends Exception
{
    const MESSAGE = "Connection is not initialized";

    public function __construct($message = self::MESSAGE, $code = 0, Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}