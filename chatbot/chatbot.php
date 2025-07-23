<?php
header('Content-Type: application/json');

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "chatbot";
$apiKey = "sk-proj-X71uVgm7v12gh0nxdnrIT3BlbkFJIC7UmAw3nkpbBJh9tcdO";  // Replace with your OpenAI API key

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

function getBotResponse($userInput, $apiKey) {
    $url = "https://api.openai.com/v1/completions";
    $data = [
        "model" => "text-davinci-003",
        "prompt" => $userInput,
        "max_tokens" => 150,
        "temperature" => 0.7
    ];
    
    $options = [
        "http" => [
            "header" => "Content-type: application/json\r\nAuthorization: Bearer " . $apiKey . "\r\n",
            "method" => "POST",
            "content" => json_encode($data),
            "ignore_errors" => true
        ],
    ];

    $context = stream_context_create($options);
    $result = file_get_contents($url, false, $context);

    if ($result === FALSE) {
        return "Error: Unable to get a response from OpenAI API.";
    }

    $response = json_decode($result, true);
    
    return isset($response['choices'][0]['text']) ? $response['choices'][0]['text'] : "Error: Invalid response from OpenAI API.";
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $input = json_decode(file_get_contents('php://input'), true);
    if (isset($input['message'])) {
        $message = $conn->real_escape_string($input['message']);
        $response = getBotResponse($message, $apiKey);

        // Save chat history
        $stmt = $conn->prepare("INSERT INTO chat_history (user_message, bot_response) VALUES (?, ?)");
        $stmt->bind_param("ss", $message, $response);
        $stmt->execute();

        echo json_encode(['response' => nl2br(htmlspecialchars($response))]);
    } else {
        echo json_encode(['error' => 'No message provided.']);
    }
} else {
    echo json_encode(['error' => 'Invalid request method.']);
}

$conn->close();
?>
