<?php

require_once __DIR__ . "/../database/repos/user-repo.php";

use Database\Repos\UserRepo;

session_start();

if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    header("Location: /public/login.php?error=Invalid request method");
}

if (isset($_SESSION["user_id"])) {
    header("Location: /public/chat.php");
}

if (!isset($_POST["name"]) || !isset($_POST["password"])) {
    header("Location: /public/login.php?error=Name and password are required");
}

$username = $_POST["name"];
$password = $_POST["password"];

$user_repo = new UserRepo();

try {
    $user = $user_repo->get_user_by_name($username);
} catch (\Exception $e) {
    header("Location: /public/login.php?error=" . $e->getMessage());
}

if (!password_verify($password, $user->get_password_hash())) {
    header("Location: /public/login.php?error=Invalid username or password");
}

$_SESSION["user_id"] = $user->get_id();
$_SESSION["username"] = $user->get_name();

header("Location: /public/chat.php");
