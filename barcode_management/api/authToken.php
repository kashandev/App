<?php
include('config.php');

$api_key = $_POST['api_key'];
$api_secret = $_POST['api_secret'];

if($api_key=='ogMGiNOaks' && $api_secret=='9515') {
    $current_time = date('Y-m-d H:i:s');
    $expiry_time = date("YmdHis", strtotime($current_date . '+50 minute'));
    $expiry_time_bin = bin2hex($expiry_time);
    $ip = bin2hex($_SERVER['REMOTE_ADDR']);
    $token = strrev($expiry_time_bin.'fae'.$ip);
    $_SESSION['token']=$token;
    $json = array(
        'success' => false,
        'token' => $token,
    );
} else {
    $json = array(
        'success' => false,
        'error' => 'Invalid API Key or Secret'
    );
}

$message = '['.date('Y-m-d H:i:s').'] - '.$_SERVER['REMOTE_ADDR'].' - authToken'.PHP_EOL;
$message .= 'Request: '.json_encode(array('get'=>$_GET, 'post'=>$_POST)).PHP_EOL;
$message .= 'Response: '.json_encode($json).PHP_EOL;
file_put_contents('api.log', $message , FILE_APPEND | LOCK_EX);

echo json_encode($json);
exit;

?>
