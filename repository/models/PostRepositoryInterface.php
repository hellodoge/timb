<?php

namespace repository\models;

interface PostRepositoryInterface
{
    public function getRecent(int $limit, int $offset): array;
}