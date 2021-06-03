<?php

namespace repository\models;

use models\Post;

interface PostRepositoryInterface
{
    public function getRecent(int $limit, int $offset): array;
    public function getPostByID(int $id): ?Post;
    /**
     * @return int post id
     */
    public function createPost(int $author, ?int $reply_to, string $text): int;
}