<?php

namespace app;

function validatePresenceOfFields($request, $fields): bool
{
    foreach ($fields as $field)
    {
        if (!isset($request[$field]))
        {
            sendResponse(BAD_REQUEST, "Field '" . $field . "' is required");
            return false;
        }
    }
    return true;
}