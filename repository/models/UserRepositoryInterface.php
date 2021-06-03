<?php

namespace repository\models;

use models\User;

interface UserRepositoryInterface
{
    /**
     * @return int user id
     */
    public function createNew(User $user): int;
    public function getByUsername(string $username): ?User;
}