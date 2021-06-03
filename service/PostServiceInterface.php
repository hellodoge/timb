<?php

namespace service;

interface PostServiceInterface
{
    public function getRecent(int $limit, int $offset);
}