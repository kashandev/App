<?php
// Include the config.php file
require_once dirname(dirname(__DIR__)) . DIRECTORY_SEPARATOR . 'config.php';
// Directory where files will be saved
$uploadDirectory = URL_UPLOAD;

$json = [];
$fileName = '';
$fileSize = '';
$message = '';
// Check if a company was post
header('Content-Type: application/json');

// Ensure the upload directory exists
if (!is_dir($uploadDirectory)) {
    mkdir($uploadDirectory, 0777, true);
}

// Check if a file was uploaded
if (!empty($_POST['file_name'])) {

    // Retrieve file details from the $_FILES array
    $fileName = $_POST['file_name'];
    $fileTmpPath = $_POST['file_tmp_name'];
    $fileSize = $_POST['file_size'];
    $fileType = $_POST['file_type'];
    $fileError = $_POST['file_error'];

    // Define the path where the file will be saved
    $destination = $uploadDirectory;

    
    // // Move the uploaded file to the destination directory
    if (move_uploaded_file($fileTmpPath, $destination)) {
 

       $json = [
            'success' => true,
            'title' => 'Success',
            'message' => 'File uploaded successfully!',
            'filePath' => $destination,
            'status' => 200
        ];
    } else {

        $json = [
            'success' => false,
            'title' => 'Error',
            'message' => 'Failed to uploaded file!',
            'status' => 400
        ];
    }
} else {
    $json = [
        'success' => false,
        'title' => 'Bad Request',
        'message' => 'Invalid Parameters!',
        'status' => 403
    ];
}

echo json_encode($json);
?>
