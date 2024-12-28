<?php

namespace Entities;

require_once __DIR__ . "/../utils/validate-id.php";

use function Utils\validate_id;

class User
{
    private $id;
    private $name;
    private $password_hash;

    public function get_id(): string
    {
        return $this->id;
    }

    public function set_id($id)
    {
        validate_id($id);

        $this->id = $id;
    }

    public function get_name(): string
    {
        return $this->name;
    }

    public function set_name($name)
    {
        if (!is_string($name)) {
            throw new \Exception("Name must be a string");
        }

        if (strlen($name) < 4) {
            throw new \Exception("Name must be at least 4 characters long");
        }

        if (strlen($name) > 12) {
            throw new \Exception("Name must be at most 12 characters long");
        }

        if (!preg_match("/^[a-zA-Z0-9]+$/", $name)) {
            throw new \Exception("Name must only contain letters and numbers");
        }

        $this->name = $name;
    }

    public function get_password_hash(): string
    {
        return $this->password_hash;
    }

    public function set_password($password)
    {
        if (!is_string($password)) {
            throw new \Exception("Password must be a string");
        }

        if (strlen($password) < 4) {
            throw new \Exception("Password must be at least 4 characters long");
        }

        if (strlen($password) > 32) {
            throw new \Exception("Password must be at most 32 characters long");
        }

        $this->password_hash = password_hash($password, PASSWORD_DEFAULT);
    }
}
