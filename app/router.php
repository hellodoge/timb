<?php

namespace app;

use app\handlers\Handler;
use app\handlers\PostHandler;
use router\Router;

function initRoutes(Handler $handler): Router
{
    $router = new Router();

    $api = $router->group('api');
    initApiRoutes($api, $handler);

    $router->setCallbackNotFound(function() {
        http_response_code(NOT_FOUND);
        echo '404 Page not found';
    });

    return $router;
}

function initApiRoutes(Router $router, Handler $handler)
{
    $posts = $router->group('posts');
    initPostsRoutes($posts, $handler->post);
}

function initPostsRoutes(Router $router, PostHandler $handler)
{
    $router->GET('recent', function($args) use ($handler) {
        $handler->getRecent($args);
    });
}