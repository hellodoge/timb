<?php

namespace repository\models\postgres;

use PDO;
use repository\exceptions\ConnectionIsNullException;
use repository\exceptions\FailedReadingQueryException;
use repository\models\PostRepositoryInterface;
use repository\Postgres;

class PostRepositoryPostgres implements PostRepositoryInterface
{
    private Postgres $db;

    const GET_RECENT_QUERY_FILENAME = 'get_recent_posts.sql';

    public function __construct($db)
    {
        $this->db = $db;
    }

    /**
     * @throws ConnectionIsNullException
     * @throws FailedReadingQueryException
     */
    public function getRecent(int $limit, int $offset): array
    {
        static $query = null;
        if (is_null($query))
        {
            $query = $this->db->readQuery(PostRepositoryPostgres::GET_RECENT_QUERY_FILENAME);
        }

        $stmt = $this->db->getConnection()->prepare($query);

        $stmt->execute(array("l"=>$limit, "o"=>$offset));

        return $stmt->fetchAll(PDO::FETCH_CLASS, "\\models\\Post");
    }
}