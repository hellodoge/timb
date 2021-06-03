<?php

namespace service\exceptions;

use Throwable;

class InvalidCredentials extends ServiceException
{
    const MESSAGE = "Invalid credentials";

    public function __construct($message = self::MESSAGE, $code = 0, Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}