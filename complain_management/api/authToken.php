<?php
include('config.php');

$login_name = $_POST['login_name'];
$login_password = $_POST['login_password'];

$con = mysqli_connect(DB_SERVER,DB_USER,DB_PASSWORD,DB_MASTER);

$sql = "SELECT *";
$sql .= " FROM `user`";
//$sql .= " WHERE `login_name` = 'hums_fas' AND login_password = MD5('12345678');";
$sql .= " WHERE `login_name` = '".$login_name."' AND login_password = MD5('".$login_password."');";
$query = $con->query($sql);
if($query->num_rows) {
    $user = $query->fetch_assoc();

    $sql = "SELECT *";
    $sql .= " FROM `user_branch_access`";
    $sql .= " WHERE user_id = '".$user['user_id']."'";
    $query = $con->query($sql);
    if($query->num_rows==0) {
        $json = array(
            'success' => false,
            'error' => 'No access for this user'
        );
    } elseif($query->num_rows>1) {
        $json = array(
            'success' => false,
            'error' => 'Multiple Branch Access. Contact System Administrator'
        );
    } else {
        $branch_access = $query->fetch_assoc();
        $sql = "SELECT *";
        $sql .= " FROM `company_branch`";
        $sql .= " WHERE company_branch_id = '".$branch_access['company_branch_id']."'";
        $query = $con->query($sql);
        if($query->num_rows) {
            $branch = $query->fetch_assoc();
            $current_time = date('Y-m-d H:i:s');
            $expiry_time = date("YmdHis", strtotime($current_date . '+60 minute'));
            $expiry_time_bin = bin2hex($expiry_time);
            $ip = bin2hex($_SERVER['REMOTE_ADDR']);
            $token = strrev($expiry_time_bin.'fae'.$ip);
            $_SESSION['token']=$token;
            $_SESSION['company_id']=$branch_access['company_id'];
            $_SESSION['company_branch_id']=$branch_access['company_branch_id'];
            $_SESSION['br_code']=$branch['branch_code'];
            $_SESSION['user_id']=$user['user_id'];
            $json = array(
                'success' => true,
                'token' => $token,
            );

        }
    }
} else {
    $json = array(
        'success' => false,
        'error' => 'Invalid Login'
    );
}

$message = '['.date('Y-m-d H:i:s').'] - '.$_SERVER['REMOTE_ADDR'].' - authToken'.PHP_EOL;
$message .= 'Request: '.json_encode(array('get'=>$_GET, 'post'=>$_POST)).PHP_EOL;
$message .= 'Response: '.json_encode($json).PHP_EOL;
file_put_contents('api.log', $message , FILE_APPEND | LOCK_EX);

echo json_encode($json);
exit;

?>
