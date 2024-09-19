<?php
// include session //
include_once('../session/session.php'); // this is used for include session //
// end of include session //
// include ip //
include_once('../ip/ip.php'); // this is used for include ip //
// end of include ip //
// include conn //
include_once('../conn/config.php'); // this is used for include conn //
// end of include conn //
// include date //
include_once ("../date/date.php"); // this is used for include date//
// end of include date //
$remarks = '';
$user_id_pk = '';
$user_role_id  = '';
$user_name = '';
if (isset($_SESSION['user_id_pk'])) {
    $user_id_pk = $_SESSION['user_id_pk'];
    $user_name  = $_SESSION['user_name'];
    $user_role_id  = $_SESSION['user_role_id'];
    $user_role  = $_SESSION['user_role'];
    $remarks = $user_role . " " . "logout";

    $sql = "INSERT INTO `user_login`(`uid`,`remarks`,`logindate`,`device`,`ip`,`islogin`,`status`)
                 VALUES ('$user_id_pk','$remarks','".$Logout_Date."','$device','$ip',0,'logout')";  
    $res  = mysqli_query($conn, $sql);   

   $sql = "INSERT INTO `user_logout`(`uid`,`remarks`,`logoutdate`,`device`,`ip`,`islogout`,`status`)
                 VALUES ('$user_id_pk','$remarks','".$Logout_Date."','$device','$ip',1,'logout')";  
    $res  = mysqli_query($conn, $sql);  

    $sql  = "INSERT INTO `user_activity`(`uid`,`remarks`,`activitydate`,`device`,`ip`,`status`)
                 VALUES ('$user_id_pk','$remarks','".$Logout_Date."','$device','$ip','login')";
    $res                         = mysqli_query($conn, $sql);
    unset($_SESSION['user_id_pk']);
    sleep(1);
    echo "<script>location.assign('../index.php')</script>";
    $_SESSION['signout_message'] = 'You Have Logged Out';
}
?>