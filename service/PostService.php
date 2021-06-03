<?php

namespace service;

use service\exceptions\InvalidArgumentException;
use models\Post;
use repository\models\PostRepositoryInterface;

class PostService implements PostServiceInterface
{
    private PostRepositoryInterface $repo;

    public function __construct(PostRepositoryInterface $repo)
    {
        $this->repo = $repo;
    }

    public function getRecent(int $limit, int $offset): array
    {
        if ($limit < 0)
        {
            throw new InvalidArgumentException("'limit' mut not be negative");
        }
        if ($offset < 0)
        {
            throw new InvalidArgumentException("'offset' mut not be negative");
        }

        return $this->repo->getRecent($limit, $offset);
    }

    public function getPostByID(int $id): ?Post
    {
        return $this->repo->getPostByID($id);
    }
}