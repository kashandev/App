<?php
// signout //
// include session //
include_once '../session/session.php'; // this is used for include session //
// end of include session //
// include ip //
include_once '../ip/ip.php'; // this is used for include ip //
// end of include ip //
// include conn //
include_once '../conn/conn.php'; // this is used for include conn //
// end of include conn //
// include date //
include_once "../date/date.php"; // this is used for include date//
// end of include date //
$remarks   = '';
$u_id_pk   = '';
$login_id  = '';
$u_role_id = '';
$u_name    = '';
if (isset($_SESSION['u_id_pk']) == '') {
    echo "<script>location.assign('../signin.php')</script>";
}
if (isset($_SESSION['u_id_pk'])) {
    $u_id_pk   = $_SESSION['u_id_pk'];
    $login_id  = $_SESSION['login_id'];
    $u_name    = $_SESSION['u_name'];
    $u_role_id = $_SESSION['u_role_id'];
    $u_role    = $_SESSION['u_role'];
    $remarks   = $u_role . " " . "logout";
    
    $sql = "INSERT INTO `user_login`(`uid`,`remarks`,`loginid`,`logindate`,`device`,`ip`,`islogin`,`status`)
                 VALUES ('$u_id_pk','$remarks','$login_id','" . $Logout_Date . "','$device','$ip',0,'logout')";
    $res = mysqli_query($conn, $sql);
    
    $sql = "INSERT INTO `user_logout`(`uid`,`remarks`,`loginid`,`logoutdate`,`device`,`ip`,`islogout`,`status`)
                 VALUES ('$u_id_pk','$remarks','$login_id','" . $Logout_Date . "','$device','$ip',1,'logout')";
    $res = mysqli_query($conn, $sql);
    
    $sql = "INSERT INTO `user_activity`(`uid`,`remarks`,`activitydate`,`device`,`ip`,`status`)
                 VALUES ('$u_id_pk','$remarks','" . $Logout_Date . "','$device','$ip','login')";
    $res = mysqli_query($conn, $sql);
    unset($_SESSION['u_id_pk']);
    unset($_SESSION['login_id']);
    sleep(1);
    echo "<script>location.assign('../index.php')</script>";
    $_SESSION['signout_user_message'] = 'You Have Logged Out';
}
?>