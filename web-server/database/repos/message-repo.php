<?php

namespace Database\Repos;

require_once __DIR__ . "/../database.php";
require_once __DIR__ . "/../../entities/message.php";

use Database\Database;
use Entities\Message;

class MessageRepo {
    private $db;

    public function __construct() {
        $this->db = new Database();
    }

    public function create_message(Message $message) {
        $stmt = $this->db->prepare("INSERT INTO messages (id, sender_id, content) VALUES (:id, :sender_id, :content)");

        $stmt->bindParam(":id", $message->get_id());
        $stmt->bindParam(":sender_id", $message->get_sender_id());
        $stmt->bindParam(":content", $message->get_content());
        
        $stmt->execute();
    }

    public function get_all_messages(): array {
        $stmt = $this->db->prepare("SELECT * FROM messages ORDER BY created_at;");
        $stmt->execute();

        $messages = [];

        foreach ($stmt->fetchAll() as $row) {
            $message = new Message();

            $message->set_id($row["id"]);
            $message->set_sender_id($row["sender_id"]);
            $message->set_content($row["content"]);

            $messages[] = $message;
        }

        return $messages;
    }
}
