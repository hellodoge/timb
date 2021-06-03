<?php

namespace service;

class ServiceConfig
{
    public UserServiceConfig $user;

    function __construct()
    {
        $this->user = new UserServiceConfig();
    }
}