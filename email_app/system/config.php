<?php
// **a. Define URL Constants**
$host = '';
$base = '';
$image = '';

if (isset($_SERVER['HTTP_HOST']) && $_SERVER['HTTP_HOST'] === 'localhost') {
    $host = 'http://' . $_SERVER['HTTP_HOST'] . '/email_app/';
    $base = $host . 'assets/';
    $image = $base . 'image/';
} else {
    $host = 'https://' . $_SERVER['HTTP_HOST'] . '/email_app/';
    $base = $host . 'assets/';
    $image = $base . 'image/';
}

define('HOST_URL', $host);
define('BASE_URL', $base);
define('IMAGE_URL', $image);

// **b. Define Filesystem Path Constants**
// __DIR__ refers to the directory of this config.php file
define('DIR_ROOT', dirname(__DIR__) . DIRECTORY_SEPARATOR); // Moving up one level to the root directory
define('DIR_PLUGINS', DIR_ROOT . 'assets' . DIRECTORY_SEPARATOR . 'plugins');
define('DIR_SYSTEM', DIR_ROOT . 'system');
define('DIR_ENGINE', DIR_SYSTEM . DIRECTORY_SEPARATOR . 'engine');
define('DIR_CONTROLLER', DIR_SYSTEM . DIRECTORY_SEPARATOR . 'controller' . DIRECTORY_SEPARATOR);
define('DIR_MAILER', DIR_SYSTEM . DIRECTORY_SEPARATOR . 'PHPMailer');
define('DIR_EXCEPTION', DIR_MAILER . DIRECTORY_SEPARATOR . 'src' . DIRECTORY_SEPARATOR . 'Exception.php');
define('DIR_MAIL', DIR_MAILER . DIRECTORY_SEPARATOR . 'src' . DIRECTORY_SEPARATOR . 'PHPMailer.php');
define('DIR_SMTP', DIR_MAILER . DIRECTORY_SEPARATOR . 'src' . DIRECTORY_SEPARATOR . 'SMTP.php');

// Define URL paths for controllers (if needed)
define('URL_SEND_CONTROLLER', HOST_URL . 'system/controller/send/send.php'); // Adjust path as needed
define('URL_FILE_CONTROLLER', HOST_URL . 'system/controller/file/file.php');
define('URL_UPLOAD', BASE_URL . 'upload/');
define('URL_IMAGE', IMAGE_URL);

// **c. Include PHPMailer Files Using Filesystem Paths**
require_once DIR_EXCEPTION;
require_once DIR_MAIL;
require_once DIR_SMTP;

// **DB Configuration**
define('DB_DRIVER', 'dbmysqli');
define('DB_HOSTNAME', 'localhost');
define('DB_USERNAME', 'root');
define('DB_PASSWORD', '');
define('DB_DATABASE', 'email_app');
define('DB_PREFIX', '');

// **Error and Application Configuration**
define('CONFIG_DISPLAY_ERROR', 0);
define('CONFIG_LOG_ERROR', 1);
define('CONFIG_ERROR_FILE_NAME', 'error_' . date('Ymd') . '.log');
define('CONFIG_APPLICATION_CODE', 'emailapp');
define('CONFIG_APPLICATION_NAME', 'Email App');

// **Date Formats**
define('PICKER_DATE', 'DD-MM-YYYY');
define('PICKER_DATE_TIME', 'DD-MM-YYYY HH:mm:ss');
define('PICKER_TIME', 'HH:mm');
define('STD_DATE', 'd-m-Y');
define('MYSQL_DATE', 'Y-m-d');
define('STD_DATETIME', 'd-m-Y H:i:s');
define('MYSQL_DATETIME', 'Y-m-d H:i:s');
?>
