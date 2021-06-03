<?php

namespace util;

use Exception;

function printStackTrace(Exception $e)
{
    $stderr = fopen('php://stderr', 'w');
    fwrite($stderr, $e->getTraceAsString() . PHP_EOL);
}