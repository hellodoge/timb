<?php

namespace repository;

use repository\models\postgres\PostRepositoryPostgres;

class Postgres extends Database
{
    const QUERIES_FOLDER = 'postgres';

    /**
     * @throws exceptions\QueryNotFoundException
     */
    function __construct($dsn, $username, $password)
    {
        parent::__construct($dsn, $username, $password);
        $this->post = new PostRepositoryPostgres($this);
        $this->setQueriesFolder($this->queries_folder . DIRECTORY_SEPARATOR . self::QUERIES_FOLDER);
    }
}