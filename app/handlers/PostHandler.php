<?php

namespace app\handlers;

use InvalidArgumentException;
use service\PostServiceInterface;

class PostHandler
{
    private PostServiceInterface $service;

    const LIMIT_DEFAULT = 20;
    const LIMIT_MAX = 100;

    function __construct(PostServiceInterface $service)
    {
        $this->service = $service;
    }

    public function getRecent($args)
    {
        $result_set = array();
        try
        {
            $limit = isset($args['limit']) ? intval($args['limit']) : self::LIMIT_DEFAULT;
            $offset = isset($args['offset']) ? intval($args['offset']) : 0;
            if ($limit > self::LIMIT_MAX)
            {
                throw new InvalidArgumentException(
                    "'limit' must not be greater, than " . self::LIMIT_MAX
                );
            }
            $result_set['posts'] = $this->service->getRecent($limit, $offset);
        }
        catch (InvalidArgumentException $e)
        {
            sendErrorResponse(BAD_REQUEST, $e->getMessage());
            return;
        }
        echo json_encode($result_set);
    }
}