<?php

namespace service;

use service\exceptions\InvalidArgumentException;
use models\Post;
use repository\models\PostRepositoryInterface;
use service\exceptions\NotFoundException;

class PostService implements PostServiceInterface
{
    private PostRepositoryInterface $repo;

    const TEXT_LENGTH_MAX = 256;

    public function __construct(PostRepositoryInterface $repo)
    {
        $this->repo = $repo;
    }

    /**
     * @throws InvalidArgumentException
     */
    public function getRecent(int $limit, int $offset): array
    {
        if ($limit < 0)
            throw new InvalidArgumentException("'limit' mut not be negative");
        if ($offset < 0)
            throw new InvalidArgumentException("'offset' mut not be negative");

        return $this->repo->getRecent($limit, $offset);
    }

    public function getPostByID(int $id): ?Post
    {
        return $this->repo->getPostByID($id);
    }

    /**
     * @throws NotFoundException
     * @throws InvalidArgumentException
     */
    public function createPost(int $author, ?int $reply_to, string $text): int {
        if (!is_null($reply_to) && is_null($this->repo->getPostByID($reply_to)))
        {
            throw new NotFoundException("post with given id not found");
        }

        if (strlen($text) > self::TEXT_LENGTH_MAX)
        {
            throw new InvalidArgumentException(
                "'text' length must not be greater than " . self::TEXT_LENGTH_MAX
            );
        }

        return $this->repo->createPost($author, $reply_to, $text);
    }
}