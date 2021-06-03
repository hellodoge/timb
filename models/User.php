<?php

namespace models;

class User
{
    public int $id;
    public string $username;
    public string $full_name;
    private string $password_hash;

    public function getPasswordHash(): string
    {
        return $this->password_hash;
    }

    public function setPasswordHash(string $password_hash): void
    {
        $this->password_hash = $password_hash;
    }

}