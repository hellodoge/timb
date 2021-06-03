<?php

namespace repository\models\postgres;

use models\User;
use repository\exceptions\ConnectionIsNullException;
use repository\exceptions\FailedReadingQueryException;
use repository\models\UserRepositoryInterface;
use repository\Postgres;

class UserRepositoryPostgres implements UserRepositoryInterface
{
    private Postgres $db;

    const CREATE_NEW_QUERY_FILENAME = "create_new_user.sql";
    const GET_BY_USERNAME_QUERY_FILENAME = "get_user_by_username.sql";

    public function __construct($db)
    {
        $this->db = $db;
    }

    /**
     * @throws FailedReadingQueryException
     * @throws ConnectionIsNullException
     */
    public function createNew(User $user): int
    {
        static $query = null;
        if (is_null($query))
        {
            $query = $this->db->readQuery(self::CREATE_NEW_QUERY_FILENAME);
        }
        $stmt = $this->db->getConnection()->prepare($query);

        $stmt->execute([
            "username" => $user->username,
            "full_name" => $user->full_name,
            "password_hash" => $user->getPasswordHash(),
        ]);

        return $stmt->fetch()['id'];
    }

    /**
     * @throws FailedReadingQueryException
     * @throws ConnectionIsNullException
     */
    public function getByUsername(string $username): ?User
    {
        static $query = null;
        if (is_null($query))
        {
            $query = $this->db->readQuery(self::GET_BY_USERNAME_QUERY_FILENAME);
        }
        $stmt = $this->db->getConnection()->prepare($query);

        $stmt->execute(["username"=>$username]);
        $user = $stmt->fetchObject("\\models\\User");
        if ($user == false)
            return null;
        return $user;
    }
}