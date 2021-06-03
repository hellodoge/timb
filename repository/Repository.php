<?php

namespace repository;

use repository\models\PostRepositoryInterface;

abstract class Repository
{
    public PostRepositoryInterface $post;
}