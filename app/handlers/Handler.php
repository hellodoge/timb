<?php

namespace app\handlers;

use service\Service;

class Handler
{
    public PostHandler $post;
    public UserHandler $user;

    function __construct(Service $service)
    {
        $this->post = new PostHandler($service->post);
        $this->user = new UserHandler($service->user);
    }
}