<?php

namespace app;

use service\exceptions\ServiceException;
use service\UserServiceInterface;

const BEARER_TOKEN_PREFIX = "Bearer ";
const USER_ID_CONTEXT_KEY = "user-id";

function getUserID(UserServiceInterface $service): ?int
{
    if (!isset($_SERVER['HTTP_AUTHORIZATION']))
    {
        sendResponse(UNAUTHORIZED, "Empty authorization header");
        return null;
    }
    $header = $_SERVER['HTTP_AUTHORIZATION'];
    if (!str_starts_with($header, BEARER_TOKEN_PREFIX))
    {
        sendResponse(UNAUTHORIZED, "Expected Bearer authorization header");
        return null;
    }
    $token = substr($header, strlen(BEARER_TOKEN_PREFIX));

    try
    {
        return $service->parseToken($token);
    }
    catch (ServiceException $e)
    {
        sendResponse(UNAUTHORIZED, $e->getMessage());
        return null;
    }
}