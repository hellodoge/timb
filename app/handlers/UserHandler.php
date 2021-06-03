<?php

namespace app\handlers;

use InvalidArgumentException;
use service\UserServiceInterface;

class UserHandler
{
    private UserServiceInterface $service;

    function __construct(UserServiceInterface $service)
    {
        $this->service = $service;
    }

    function signIn($args)
    {
        $request = json_decode(file_get_contents('php://input'), true);
        if (is_null($request))
        {
            $request = $args;
        }
        else
        {
            $request = array_merge($request, $args);
        }

        foreach (['username', 'password', 'full_name'] as $field)
        {
            if (!isset($request[$field]))
            {
                sendResponse(BAD_REQUEST, "Field '" . $field . "' is required");
                return;
            }
        }
        try
        {
            $id = $this->service->createNew($request['username'], $request['password'], $request['full_name']);
            echo json_encode(["id"=>$id]);
        }
        catch (InvalidArgumentException $e)
        {
            sendResponse(BAD_REQUEST, $e->getMessage());
            return;
        }
    }
}