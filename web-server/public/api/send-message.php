<?php

require_once __DIR__ . "/../../utils/sendjson.php";
require_once __DIR__ . "/../../utils/generate-uuid.php";
require_once __DIR__ . "/../../entities/message.php";
require_once __DIR__ . "/../../database/repos/message-repo.php";

use function Utils\sendjson;
use function Utils\generate_uuid;
use Entities\Message;
use Database\Repos\MessageRepo;

session_start();

if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    http_response_code(405);
    sendjson(["error" => "Method not allowed"]);
    exit;
}

if (!isset($_SESSION["user_id"])) {
    http_response_code(401);
    sendjson(["error" => "Not logged in"]);
    exit;
}

if (!isset($_POST["content"])) {
    http_response_code(400);
    sendjson(["error" => "Content is required"]);
    exit;
}

$user_id = $_SESSION["user_id"];
$content = $_POST["content"];

$message = new Message();

try {
    $message->set_id(generate_uuid());
    $message->set_sender_id($user_id);
    $message->set_content($content);
} catch (\Exception $e) {
    http_response_code(400);
    sendjson(["error" => $e->getMessage()]);
    exit;
}

$message_repo = new MessageRepo();

try {
    $message_repo->create_message($message);
} catch (\Exception $e) {
    http_response_code(500);
    sendjson(["error" => $e->getMessage()]);
    exit;
}

http_response_code(201);
sendjson(["message" => "Message sent"]);
