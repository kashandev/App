<?php
// restore user //
// include session //
include_once "../session/session.php"; // this is used for include session//
// end of include session //
// include ip //
include_once "../ip/ip.php"; // this is used for include ip //
// end of include ip //
// include conn //
include_once('../../conn/conn.php'); // this is used for include conn //
// end of include conn //

$data = [];
$msg = "";
$btn = "";
$timestamp = "";
$blacklistdate = "";
$date = "";
$dpid = "";
$uid = "";
$uname = "";
$blockby = "";
$sql = "";
$res = "";
$thisuid = '';
$timestamp = time();
$blacklistdate = date("Y-m-d h:i:s", $timestamp);
$date = date("d-m-Y");
// end of variables //

if (isset($_POST["uid"])) {
    $uid = $_POST["uid"];
    $aid = $_POST["aid"];
    $blockby = $_POST["uname"];
    $remarks = "block user";
     foreach ($uid as $key => $thisuid) {
     $thisuid = $uid[$key];
 
     $sql = "UPDATE users set isdeleted = 1, isblock = 1, blacklistdate = '".$blacklistdate."', blockby = '".$blockby."' where userid = '".$thisuid."'";

       $res = mysqli_query($conn, $sql);
   

        $sql = "INSERT INTO `block_history`(`uid`,`createdate`,`createby`,`device`,`ip`,`status`)
            VALUES ('$thisuid','$blacklistdate','$blockby','$device','$ip','restore')";
        $res = mysqli_query($conn, $sql);


     $sql =
            "INSERT INTO `user_activity`(`uid`,`remarks`,`activitydate`,`device`,`ip`,`status`)
                 VALUES ('$aid','$remarks','" .
            $blacklistdate .
            "','$device','$ip','block')";
      $res = mysqli_query($conn, $sql); 
     }
    if($res)
    {

    $msg = "User successfully block ";
    }
    else {
        $msg = "Failed";
    }
    $data = [
        "msg" => $msg,
    ];


echo json_encode($data);
}
?>
