<?php

namespace Database\Repos;

require_once __DIR__ . "/../database.php";
require_once __DIR__ . "/../../entities/user.php";

use Database\Database;
use Entities\User;

class UserRepo {
    private $db;

    public function __construct() {
        $this->db = new Database();
    }

    public function get_user_by_id($id): User {
        $stmt = $this->db->prepare("SELECT * FROM users WHERE id = :id");

        $stmt->bindParam(":id", $id);
        $stmt->execute();

        $user = $stmt->fetchObject(User::class);

        if (!$user) {
            throw new \Exception("User not found");
        }

        return $user;
    }

    public function get_user_by_name($name): User {
        $stmt = $this->db->prepare("SELECT * FROM users WHERE name = :name");

        $stmt->bindParam(":name", $name);
        $stmt->execute();

        $user = $stmt->fetchObject(User::class);

        if (!$user) {
            throw new \Exception("User not found");
        }

        return $user;
    }

    public function create_user(User $user) {
        $stmt = $this->db->prepare("INSERT INTO users (id, name, password_hash) VALUES (:id, :name, :password_hash);");

        $stmt->bindParam(":id", $user->get_id());
        $stmt->bindParam(":name", $user->get_name());
        $stmt->bindParam(":password_hash", $user->get_password_hash());
        
        $stmt->execute();
    }
}
