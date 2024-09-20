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
$thisduid = '';
$timestamp = time();
$restoredate = date("Y-m-d h:i:s", $timestamp);
$date = date("d-m-Y");
// end of variables //
if (isset($_POST["duid"])) {
    $duid = $_POST["duid"];
    $aid = $_POST["aid"];
    $restoreby = $_POST["uname"];
    $remarks = "restore user";
     foreach ($duid as $key => $thisduid) {
     $thisduid = $duid[$key];

     $sql = "UPDATE users set isdeleted = 0, isrestore = 1, restoredate = '".$restoredate."', restoreby = '".$restoreby."' where userid = '".$thisduid."'";

       $res = mysqli_query($conn, $sql);
   

        $sql = "INSERT INTO `restore_history`(`uid`,`createdate`,`createby`,`device`,`ip`,`status`)
            VALUES ('$thisduid','$restoredate','$restoreby','$device','$ip','restore')";
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

    $msg = "User successfully restored ";
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
