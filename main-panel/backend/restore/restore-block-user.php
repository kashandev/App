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
$restoredate = "";
$date = "";
$dpid = "";
$uid = "";
$uname = "";
$restoreby = "";
$sql = "";
$res = "";
$thisbuid = '';
$timestamp = time();
$restoredate = date("Y-m-d h:i:s", $timestamp);
$date = date("d-m-Y");
// end of variables //
if (isset($_POST["buid"])) {
    $buid = $_POST["buid"];
    $aid = $_POST["aid"];
    $restoreby = $_POST["uname"];
    $remarks = "restore block user";
     foreach ($buid as $key => $thisbuid) {
     $thisbuid = $buid[$key];


     $sql = "UPDATE users set isrestore = 1, isdeleted = 0, isblock = 0, restoredate = '".$restoredate."', restoreby = '".$restoreby."' where userid = '".$thisbuid."'";

      $res = mysqli_query($conn, $sql);


        $sql = "INSERT INTO `restore_history`(`uid`,`createdate`,`createby`,`device`,`ip`,`status`)
            VALUES ('$thisbuid','$restoredate','$restoreby','$device','$ip','restore')";
        $res = mysqli_query($conn, $sql);

     $sql =
            "INSERT INTO `user_activity`(`uid`,`remarks`,`activitydate`,`device`,`ip`,`status`)
                 VALUES ('$aid','$remarks','" .
            $restoredate .
            "','$device','$ip','restore')";
        $res = mysqli_query($conn, $sql); 


     }

    if($res)
    {

    $msg = "Block user successfully restored ";
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
