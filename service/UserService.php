<?php

namespace service;

use Exception;
use InvalidArgumentException;
use models\User;
use repository\models\UserRepositoryInterface;

class UserService implements UserServiceInterface
{
    private UserRepositoryInterface $repo;

    // must start with letter, and consist of alphanumeric/underscores
    const USERNAME_REGEX = "/^[a-z]+[a-z0-9_]*$/i";
    const USERNAME_MIN_LENGTH = 4;
    const USERNAME_MAX_LENGTH = 64;
    const FULL_NAME_MAX_LENGTH = 256;
    const PASSWORD_MIN_LENGTH = 4;

    public function __construct(UserRepositoryInterface $repo)
    {
        $this->repo = $repo;
    }

    /**
     * @throws Exception
     * @throws InvalidArgumentException
     */
    public function createNew(string $username, string $password, string $full_name): int
    {
        $regex_check = preg_match(self::USERNAME_REGEX, $username);
        if ($regex_check === false)
        {
            throw new Exception("Invalid regex: " . self::USERNAME_REGEX);
        }
        else if ($regex_check === 0)
        {
            throw new InvalidArgumentException(
                "'username' must start with letter, and consist of alphanumeric/underscores"
            );
        }

        $username_length = strlen($username);
        if ($username_length < self::USERNAME_MIN_LENGTH || $username_length > self::USERNAME_MAX_LENGTH)
        {
            throw new InvalidArgumentException(
                "'username' length must be from " . self::USERNAME_MIN_LENGTH .
                " to " . self::USERNAME_MAX_LENGTH . " characters"
            );
        }

        if (strlen($full_name) > self::FULL_NAME_MAX_LENGTH)
        {
            throw new InvalidArgumentException(
                "'full_name' length must be less than " . self::FULL_NAME_MAX_LENGTH . " characters"
            );
        }

        if (strlen($password) < self::PASSWORD_MIN_LENGTH)
        {
            throw new InvalidArgumentException(
                "'password' length must be greater than " . self::PASSWORD_MIN_LENGTH . " characters"
            );
        }

        if (!is_null($this->repo->getByUsername($username)))
        {
            throw new InvalidArgumentException(
                "user with username " . $username . " already exists"
            );
        }

        $password_hash = password_hash($password, PASSWORD_DEFAULT);
        if ($password_hash === false)
        {
            throw new Exception("password hashing failed");
        }

        $user = new User();
        $user->username = $username;
        $user->full_name = $full_name;
        $user->setPasswordHash($password_hash);

        return $this->repo->createNew($user);
    }
}