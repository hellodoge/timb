<?php

namespace util;

use Exception;

function printStackTrace(Exception $e)
{
    $stderr = fopen('php://stderr', 'w');
    fwrite($stderr, $e->getMessage() . PHP_EOL);
    fwrite($stderr, $e->getTraceAsString() . PHP_EOL);
}