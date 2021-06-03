<?php

namespace repository;

use PDO;
use repository\exceptions\ConnectionIsNullException;
use repository\exceptions\FailedReadingQueryException;
use repository\exceptions\QueryNotFoundException;

abstract class Database extends Repository
{
    protected ?PDO $connection;
    protected string $queries_folder = 'queries';

    function __construct($dsn, $username, $password)
    {
        $this->connect($dsn, $username, $password);
    }

    private function connect($dsn, $username, $password)
    {
        $this->connection = new PDO($dsn, $username, $password);
        $this->connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }

    /**
     * @throws ConnectionIsNullException
     */
    public function getConnection(): PDO
    {
        if (is_null($this->connection))
        {
            throw new ConnectionIsNullException();
        }
        return $this->connection;
    }

    /**
     * @throws FailedReadingQueryException
     */
    public function readQuery(string $filename): string
    {
        $path = $this->queries_folder . DIRECTORY_SEPARATOR . $filename;
        $content = file_get_contents($path);
        if ($content == false)
        {
            throw new FailedReadingQueryException();
        }
        return $content;
    }

    /**
     * @throws QueryNotFoundException
     */
    public function setQueriesFolder(string $path)
    {
        $updated = realpath($path);
        if ($updated == false) {
            throw new QueryNotFoundException("Queries folder not found!");
        } else {
            $this->queries_folder = $updated;
        }
    }
}