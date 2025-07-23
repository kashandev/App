<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "chatbot";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$sql = "SELECT user_message, bot_response FROM chat_history ORDER BY timestamp ASC";
$result = $conn->query($sql);

$chatHistory = [];
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $chatHistory[] = $row;
    }
}

echo json_encode($chatHistory);

$conn->close();
?>
