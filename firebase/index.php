<?php
require 'vendor/autoload.php';

use Kreait\Firebase\Factory;
use Kreait\Firebase\ServiceAccount;

// Path to your Firebase credentials JSON file
$serviceAccountPath = __DIR__.'/firebase_credentials.json';

// Initialize Firebase
$factory = (new Factory)
    ->withServiceAccount($serviceAccountPath)
    ->withDatabaseUri('https://test-9e606-default-rtdb.firebaseio.com/');

$database = $factory->createDatabase();

// Function to send a message
function sendMessage($message) {
    global $database;
    $newPost = $database
        ->getReference('messages')
        ->push([
            'message' => $message,
            'timestamp' => (new \DateTime())->format('U')
        ]);

    return $newPost->getValue();
}

// Function to get messages
function getMessages() {
    global $database;
    $reference = $database->getReference('messages');
    $messages = $reference->getValue();

    return $messages;
}

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['message'])) {
    sendMessage($_POST['message']);
    header('Location: ' . $_SERVER['PHP_SELF']);
    exit();
}

// Get existing messages
$messages = getMessages();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Chat App</title>
</head>
<body>
    <h1>Chat Room</h1>
    <div id="chat-box">
        <?php
        if ($messages) {
            foreach ($messages as $message) {
                echo '<div>' . htmlspecialchars($message['message']) . ' (' . date('Y-m-d H:i:s', $message['timestamp']) . ')</div>';
            }
        }
        ?>
    </div>
    <form method="post">
        <input type="text" name="message" placeholder="Type a message..." required>
        <button type="submit">Send</button>
    </form>
</body>
</html>
