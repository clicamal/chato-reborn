<?php

require_once __DIR__ . "/../utils/loadenv.php";

use function Utils\loadenv;

session_start();

if (!isset($_SESSION["user_id"])) {
    header("Location: login.php");
}

loadenv();

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    <title>Chat</title>

    <script src="static/scripts/get.js"></script>
    <script src="static/scripts/post.js"></script>
</head>

<body>
    <h1>Chat</h1>

    <ul id="messages">
        <template id="message-template">
            <li class="message">
                <strong class="username"></strong>
                <span class="message-content"></span>
            </li>
        </template>
    </ul>

    <form id="message-form" action="api/send-message.php" method="post">
        <input type="text" name="content" placeholder="Content">

        <button type="submit">Send</button>
    </form>

    <script defer>
        if (!window.WebSocket) {
            alert("WebSocket not supported by your browser. Real-time chat won't be available.");
        }

        const username = "<?php echo $_SESSION["username"]; ?>";
        const ws = new WebSocket("ws://localhost:<?php echo getenv("SOCKET_SERVER_BIND_PORT"); ?>");

        function appendMessage(message) {
            const messagesElement = document.getElementById("messages");

            const template = document.getElementById("message-template");

            const clone = template.content.cloneNode(true);

            const strong = clone.querySelector("strong");
            strong.textContent = message.sender_name;

            const span = clone.querySelector("span");
            span.textContent = message.content;

            messagesElement.appendChild(clone);
        }

        document.getElementById("message-form").addEventListener("submit", async function (event) {
            event.preventDefault();

            const response = await post(this.action, {
                content: this.content.value
            });

            if (response.status === 201) {
                ws.send(JSON.stringify({
                    sender_name: username,
                    content: this.content.value
                }));
            } else {
                console.error(await response.json())
            };

            this.content.value = "";
        });

        ws.onopen = () => {
            console.log("Connected to WebSocket server");
        };

        ws.onmessage = (event) => {
            const reader = new FileReader();

            reader.onload = function() {
                const message = JSON.parse(reader.result);
                
                appendMessage(message);
            };

            reader.readAsText(event.data);
        };

        ws.onclose = () => {
            console.log("WebSocket connection closed");
        };

        ws.onerror = (error) => {
            console.error("WebSocket error:", error);
        };

        (async () => {
            const response = await get("api/get-all-messages.php");

            const messages = await response.json();

            for (const message of messages) {
                appendMessage(message);
            }
        })();
    </script>
</body>

</html>
