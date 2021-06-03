<?php

namespace util;

function getPostRequest($args): array
{
    $request = json_decode(file_get_contents('php://input'), true);
    if (is_null($request))
    {
        $request = $args;
    }
    else
    {
        $request = array_merge($request, $args);
    }
    return $request;
}