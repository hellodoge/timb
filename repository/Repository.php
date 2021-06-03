<?php

namespace repository;

use repository\models\PostRepositoryInterface;
use repository\models\UserRepositoryInterface;

abstract class Repository
{
    public PostRepositoryInterface $post;
    public UserRepositoryInterface $user;
}