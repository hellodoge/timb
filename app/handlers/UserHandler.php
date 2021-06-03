<?php

namespace app\handlers;

use service\exceptions\ServiceException;
use service\UserServiceInterface;
use function app\sendResponse;
use function app\validatePresenceOfFields;
use function util\getPostRequest;
use const app\BAD_REQUEST;

class UserHandler
{
    private UserServiceInterface $service;

    function __construct(UserServiceInterface $service)
    {
        $this->service = $service;
    }

    function signIn($args)
    {
        $request = getPostRequest($args);
        if (!validatePresenceOfFields($request, ['username', 'password', 'full_name']))
            return;

        try
        {
            $id = $this->service->createNew($request['username'], $request['password'], $request['full_name']);
            echo json_encode(["id"=>$id]);
        }
        catch (ServiceException $e)
        {
            sendResponse(BAD_REQUEST, $e->getMessage());
            return;
        }
    }

    function logIn($args)
    {
        $request = getPostRequest($args);
        if (!validatePresenceOfFields($request, ['username', 'password']))
            return;

        try
        {
            $token = $this->service->generateToken($request['username'], $request['password']);
            echo json_encode(["token"=>$token]);
        }
        catch (ServiceException $e)
        {
            sendResponse(BAD_REQUEST, $e->getMessage());
            return;
        }
    }
}