<?php

namespace app\handlers;

use service\Service;

class Handler
{
    public PostHandler $post;

    function __construct(Service $service)
    {
        $this->post = new PostHandler($service->post);
    }
}