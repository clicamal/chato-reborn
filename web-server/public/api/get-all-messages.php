<?php

require_once __DIR__ . "/../../database/repos/message-repo.php";
require_once __DIR__ . "/../../database/repos/user-repo.php";
require_once __DIR__ . "/../../utils/sendjson.php";

use Database\Repos\MessageRepo;
use Database\Repos\UserRepo;
use function Utils\sendjson;

session_start();

if (!isset($_SESSION["user_id"])) {
    http_response_code(401);
    sendjson([ "error" => "Not logged in" ]);
}

$message_repo = new MessageRepo();
$user_repo = new UserRepo();

$messages = $message_repo->get_all_messages();

$messages = array_map(function ($message) {
    global $user_repo;

    return [
        "id" => $message->get_id(),
        "sender_name" => $user_repo->get_user_by_id($message->get_sender_id())->get_name(),
        "content" => $message->get_content()
    ];
}, $messages);

sendjson($messages);