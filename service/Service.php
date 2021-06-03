<?php

namespace service;

use repository\Repository;

class Service
{
    public PostServiceInterface $post;
    public UserServiceInterface $user;

    function __construct(Repository $database, ServiceConfig $config)
    {
        $this->post = new PostService($database->post);
        $this->user = new UserService($database->user, $config->user);
    }
}