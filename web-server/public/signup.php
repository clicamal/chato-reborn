<?php

session_start();

if (isset($_SESSION["user_id"])) {
    header("Location: chat.php");
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Signup</title>

    <link rel="stylesheet" href="static/stylesheets/form.css">
</head>
<body>
    <form id="signup-form" action="create-user.php" method="post">
        <input type="text" name="name" placeholder="Name">
        <input type="password" name="password" placeholder="Password">

        <button type="submit">Sign Up</button>

        <?php if (isset($_GET["error"])): ?>
            <div id="error-message">
                <p>Error: <?php echo $_GET["error"]; ?></p>
            </div>
        <?php endif; ?>
    </form>
</body>
</html>
