<?php

namespace service\exceptions;

use Throwable;

class InvalidArgumentException extends ServiceException
{
    const MESSAGE = "Invalid argument";

    public function __construct($message = self::MESSAGE, $code = 0, Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}