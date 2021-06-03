<?php

namespace service\exceptions;

use Throwable;

class NotFoundException extends ServiceException
{
    const MESSAGE = "Not found";

    public function __construct($message = self::MESSAGE, $code = 0, Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}