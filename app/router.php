<?php

namespace app;

use app\handlers\Handler;
use app\handlers\PostHandler;
use app\handlers\UserHandler;
use router\Router;
use service\Service;

function initRoutes(Handler $handler, Service $service): Router
{
    $router = new Router();

    $api = $router->group('api');
    initApiRoutes($api, $handler, $service);

    $auth = $router->group('auth');
    initAuthRoutes($auth, $handler->user);

    $router->setCallbackNotFound(function() {
        http_response_code(NOT_FOUND);
        echo '404 Page not found';
    });

    return $router;
}

function initApiRoutes(Router $router, Handler $handler, Service $service)
{
    $posts = $router->group('posts');
    initPostsRoutes($posts, $handler->post, $service);
}

function initPostsRoutes(Router $router, PostHandler $handler, Service $service)
{
    $router->GET('recent', function() use ($handler) {
        $handler->getRecent([]);
    });

    $router->GET('post', function() use ($handler) {
        $handler->getByID([]);
    });

    $router->POST('create', function() use ($handler, $service) {
        $user_id = getUserID($service->user);
        if (is_null($user_id))
            return;
        $handler->create([USER_ID_CONTEXT_KEY=>$user_id]);
    });
}

function initAuthRoutes(Router $router, UserHandler $handler)
{
    $router->POST('sign-in', function() use ($handler) {
        $handler->signIn([]);
    });

    $router->POST('log-in', function() use ($handler) {
        $handler->logIn([]);
    });
}