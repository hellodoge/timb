<?php

namespace service;

use DateInterval;
use Exception;
use function util\printStackTrace;

class UserServiceConfig
{
    const DEFAULT_JWT_TOKEN_LIFETIME = "P15M";

    public string $jwt_token_lifetime = self::DEFAULT_JWT_TOKEN_LIFETIME;
    public string $secret_key;

    function getTokenLifetime(): DateInterval
    {
        try
        {
            return new DateInterval($this->jwt_token_lifetime);
        }
        catch (Exception $e)
        {
            printStackTrace($e);
            return new DateInterval(self::DEFAULT_JWT_TOKEN_LIFETIME);
        }
    }
}