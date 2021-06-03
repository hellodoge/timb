<?php

namespace models;

use DateTime;
use Exception;

class Post
{
    public int $id;
    public int $author_id;
    public ?int $reply_to_id = null;
    public string $text;
    public string $created_at;

    /**
     * @throws Exception
     */
    public function createdAt(): DateTime
    {
        return new DateTime($this->created_at);
    }
}