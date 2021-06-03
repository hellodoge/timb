<?php

namespace service;

use models\Post;

interface PostServiceInterface
{
    public function getRecent(int $limit, int $offset);
    public function getPostByID(int $id): ?Post;
}