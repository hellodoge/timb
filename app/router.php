<?php

namespace app;

use app\handlers\Handler;
use app\handlers\PostHandler;
use app\handlers\UserHandler;
use router\Router;

function initRoutes(Handler $handler): Router
{
    $router = new Router();

    $api = $router->group('api');
    initApiRoutes($api, $handler);

    $auth = $router->group('auth');
    initAuthRoutes($auth, $handler->user);

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

function initAuthRoutes(Router $router, UserHandler $handler)
{
    $router->POST('sign-in', function($args) use ($handler) {
        $handler->signIn($args);
    });
}