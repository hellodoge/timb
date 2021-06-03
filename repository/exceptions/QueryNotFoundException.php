<?php

namespace repository\exceptions;

use Exception;
use Throwable;

class QueryNotFoundException extends Exception
{
    const MESSAGE = "Query file not found";

    public function __construct($message = self::MESSAGE, $code = 0, Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}