<?php

namespace service;

interface UserServiceInterface
{
    /**
     * @return int user id
     */
    public function createNew(string $username, string $password, string $full_name): int;
    public function generateToken(string $username, string $password): string;
}