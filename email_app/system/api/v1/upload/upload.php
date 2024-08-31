<?php
require_once dirname(dirname(dirname(__DIR__))) . DIRECTORY_SEPARATOR . 'config.php'; // Include config file
// Initialize cURL
$ch = curl_init();
// Use the URL constant defined in config.php
$url = URL_FILE_CONTROLLER; // Use the defined URL constant

// Prepare POST data
$postData = [

    'file_name' => $_FILES['file']['name'] ?? 'abc.jpg',
    'file_tmp_name' => $_FILES['file']['tmp_name'] ?? 'C:\xampp\htdocs\email_app\assets\images\victory.png',
    'file_size' => $_FILES['file']['size'] ?? '1kb',
    'file_type' => $_FILES['file']['type'] ?? '',
    'file_error' => $_FILES['file']['error'] ?? ''
];
 
// Set cURL options
curl_setopt($ch, CURLOPT_URL, $url); // Use the URL constant here
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($postData)); // Properly encode POST data
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

    
    // Execute cURL request and get the response
    $response = curl_exec($ch);

// // Check for cURL errors
if (curl_errno($ch)) {
    echo 'cURL error: ' . curl_error($ch);
} else {
    // Decode the response if it's in JSON format
    $result = json_decode($response, true);

    // Output the result
    echo json_encode($result);
}

// Close cURL
curl_close($ch);
?>
