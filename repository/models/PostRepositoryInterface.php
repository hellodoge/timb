<?php

namespace repository\models;

interface PostRepositoryInterface
{
    public function __construct($db);
    public function getRecent(int $limit, int $offset): array;
}