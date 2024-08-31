<?php
// Include the config.php file
require_once dirname(dirname(__DIR__)) . DIRECTORY_SEPARATOR . 'config.php';
// **Use Namespaces Correctly**
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

$json = [];
$company = '';
$email = '';
$message = '';
// Check if a company was post
header('Content-Type: application/json');

$json = [
    'success' => false,
    'title' => 'Bad Request',
    'message' => 'Invalid Parameters!',
    'status' => 403
];

if (!empty($_POST['company']) && !empty($_POST['email']) && !empty($_POST['message'])) {
    $company = $_POST['company'];
    $email = $_POST['email'];
    $message = $_POST['message'];


// Create a new PHPMailer instance
$mail = new PHPMailer(true);

try {
    // SMTP configuration
    $mail->isSMTP();
    $mail->Host = 'smtp.gmail.com';
    $mail->SMTPAuth = true;
    $mail->Username = 'kashandeveloper@gmail.com';
    $mail->Password = 'ipcosrwtyuemfwtl';
    $mail->Port = 587;

    // Email content
    $mail->setfrom('nezdeck.tech@gmail.com', 'Nezdeck Tech');
    $mail->addAddress('kashandeveloper@gmail.com', 'Kashan Developer');
    $mail->Subject = 'This is a testing email';
    $mail->Body = 'This is the test body of the email.';

    // Send the email
    $mail->send();

        $json = [
            'success' => true,
            'title' => 'Success',
            'message' => 'Email sent successfully!',
            'status' => 200
        ];

} catch (Exception $e) {
           $json = [
            'success' => false,
            'title' => 'Error',
            'message' => 'Email could not be sent!',
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