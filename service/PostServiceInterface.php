<?php

namespace service;

use repository\models\PostRepositoryInterface;

interface PostServiceInterface
{
    public function __construct(PostRepositoryInterface $repo);
    public function getRecent(int $limit, int $offset);
}