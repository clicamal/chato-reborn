<?php

require_once __DIR__ . "/../utils/generate-uuid.php";
require_once __DIR__ . "/../database/database.php";
require_once __DIR__ . "/../entities/user.php";
require_once __DIR__ . "/../database/repos/user-repo.php";

use function Utils\generate_uuid;
use Entities\User;
use Database\Repos\UserRepo;

session_start();

if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    header("Location: /public/signup.php?error=Invalid request method");
}

if (isset($_SESSION["user_id"])) {
    header("Location: /public/chat.php");
}

if (!isset($_POST["name"]) || !isset($_POST["password"])) {
    header("Location: /public/signup.php?error=Name and password are required");
}

$name = $_POST["name"];
$password = $_POST["password"];

$user = new User();

try {
    $user->set_id(generate_uuid());
    $user->set_name($name);
    $user->set_password($password);
} catch (\Exception $e) {
    header("Location: /public/signup.php?error=" . $e->getMessage());
}

$user_repo = new UserRepo();

try {
    $user_repo->create_user($user);
} catch (\Exception $e) {
    header("Location: /public/signup.php?error=" . $e->getMessage());
}

$_SESSION["user_id"] = $user->get_id();
$_SESSION["username"] = $user->get_name();

header("Location: /public/chat.php");
