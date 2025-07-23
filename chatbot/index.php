<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Chatbot</title>
    <style>
        #chatbox {
            width: 300px;
            height: 400px;
            border: 1px solid #ccc;
            padding: 10px;
            overflow-y: scroll;
        }
        .message {
            margin: 5px 0;
        }
        .user {
            color: blue;
        }
        .bot {
            color: green;
        }
    </style>
</head>
<body>
    <div id="chatbox"></div>
    <input type="text" id="userInput" placeholder="Type a message">
    <button onclick="sendMessage()">Send</button>

    <script>
        function loadChatHistory() {
            var xhr = new XMLHttpRequest();
            xhr.open("GET", "load_history.php", true);
            xhr.onreadystatechange = function () {
                if (xhr.readyState === 4 && xhr.status === 200) {
                    var chatHistory = JSON.parse(xhr.responseText);
                    var chatbox = document.getElementById("chatbox");
                    chatHistory.forEach(function (message) {
                        chatbox.innerHTML += "<div class='message user'>" + message.user_message + "</div>";
                        chatbox.innerHTML += "<div class='message bot'>" + message.bot_response + "</div>";
                    });
                    chatbox.scrollTop = chatbox.scrollHeight;
                }
            };
            xhr.send();
        }

        function sendMessage() {
            var userInput = document.getElementById("userInput").value;
            if (userInput === "") return;

            var chatbox = document.getElementById("chatbox");
            chatbox.innerHTML += "<div class='message user'>" + userInput + "</div>";

            var xhr = new XMLHttpRequest();
            xhr.open("POST", "chatbot.php", true);
            xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
            xhr.onreadystatechange = function () {
                if (xhr.readyState === 4 && xhr.status === 200) {
                    var botResponse = xhr.responseText;
                    chatbox.innerHTML += "<div class='message bot'>" + botResponse + "</div>";
                    chatbox.scrollTop = chatbox.scrollHeight;
                }
            };
            xhr.send("message=" + encodeURIComponent(userInput));

            document.getElementById("userInput").value = "";
        }

        window.onload = loadChatHistory;
    </script>
</body>
</html>
