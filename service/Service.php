<?php

namespace service;

use repository\Repository;

class Service
{
    public PostServiceInterface $post;

    function __construct(Repository $database)
    {
        $this->post = new PostService($database->post);
    }
}