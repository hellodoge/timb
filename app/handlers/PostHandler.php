<?php

namespace app\handlers;

use service\exceptions\InvalidArgumentException;
use service\exceptions\ServiceException;
use service\PostServiceInterface;
use function app\sendResponse;
use function app\validatePresenceOfFields;
use function util\getPostRequest;
use const app\BAD_REQUEST;
use const app\NOT_FOUND;
use const app\USER_ID_CONTEXT_KEY;

class PostHandler
{
    private PostServiceInterface $service;

    const LIMIT_DEFAULT = 20;
    const LIMIT_MAX = 100;

    function __construct(PostServiceInterface $service)
    {
        $this->service = $service;
    }

    public function getRecent($context)
    {
        $result_set = array();
        try
        {
            $limit = isset($_GET['limit']) ? intval($_GET['limit']) : self::LIMIT_DEFAULT;
            $offset = isset($_GET['offset']) ? intval($_GET['offset']) : 0;
            if ($limit > self::LIMIT_MAX)
            {
                throw new InvalidArgumentException(
                    "'limit' must not be greater, than " . self::LIMIT_MAX
                );
            }
            $result_set['posts'] = $this->service->getRecent($limit, $offset);
        }
        catch (ServiceException $e)
        {
            sendResponse(BAD_REQUEST, $e->getMessage());
            return;
        }
        echo json_encode($result_set);
    }

    public function getByID($context)
    {
        if (!isset($_GET['id']))
        {
            sendResponse(BAD_REQUEST, "'id' parameter required");
            return;
        }
        $post = $this->service->getPostByID(intval($_GET['id']));
        if (is_null($post))
        {
            sendResponse(NOT_FOUND, "post with given id not found");
            return;
        }
        echo json_encode(["post"=>$post]);
    }

    public function create($context)
    {
        $request = getPostRequest($_POST);
        if (!validatePresenceOfFields($request, ['text']))
            return;

        try
        {
            $reply_to_id = isset($request['reply_to']) ? intval($request['reply_to']) : null;
            $id = $this->service->createPost($context[USER_ID_CONTEXT_KEY], $reply_to_id, $request['text']);
            echo json_encode(["id"=>$id]);
        }
        catch (ServiceException $e)
        {
            sendResponse(BAD_REQUEST, $e->getMessage());
            return;
        }
    }
}