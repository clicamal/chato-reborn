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

    <title>Login</title>

    <link rel="stylesheet" href="static/stylesheets/form.css">

    <style>
        a {
            display: block;
            margin-top: 1rem;
            text-align: center;
        }
    </style>
</head>
<body>
    <form id="login-form" action="authenticate.php" method="post">
        <input type="text" name="name" placeholder="Name">
        <input type="password" name="password" placeholder="Password">

        <button type="submit">Login</button>

        <a href="signup.php">Sign Up</a>

        <?php if (isset($_GET["error"])): ?>
            <div id="error-message">
                <p>Error: <?php echo $_GET["error"]; ?></p>
            </div>
        <?php endif; ?>
    </form>
</body>
</html>
