<?php

namespace Entities;

require_once __DIR__ . "/../utils/validate-id.php";

use function Utils\validate_id;

class Message
{
    private $id;
    private $sender_id;
    private $content;

    public function get_id(): string
    {
        return $this->id;
    }

    public function set_id($id)
    {
        validate_id($id);

        $this->id = $id;
    }

    public function get_sender_id(): string
    {
        return $this->sender_id;
    }

    public function set_sender_id($sender_id)
    {
        validate_id($sender_id);

        $this->sender_id = $sender_id;
    }

    public function get_content(): string
    {
        return $this->content;
    }

    public function set_content($content)
    {
        if (!is_string($content)) {
            throw new \Exception("Content must be a string");
        }

        if (strlen($content) < 1) {
            throw new \Exception("Content must be at least 1 character long");
        }

        if (strlen($content) > 255) {
            throw new \Exception("Content must be at most 255 characters long");
        }

        $this->content = $content;
    }
}
