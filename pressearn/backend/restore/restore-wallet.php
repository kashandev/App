<?php
// restore wallet //
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
$dwaid = "";
$uid = "";
$uname = "";
$restoreby = "";
$sql = "";
$res = "";
$thisdwaid = '';
$timestamp = time();
$restoredate = date("Y-m-d h:i:s", $timestamp);
$date = date("d-m-Y");
// end of variables //
if (isset($_POST["dwaid"])) {
    $dwaid = $_POST["dwaid"];
    $aid = $_POST["aid"];
    $restoreby = $_POST["uname"];
    $remarks = "restore wallet address";
     foreach ($dwaid as $key => $thisdwaid) {
       $thisdwaid = $dwaid[$key];
 
     $sql = "UPDATE wallet_address set isdeleted = 0, isrestore = 1, restoredate = '".$restoredate."', restoreby = '".$restoreby."' where waid = '".$thisdwaid."'";
       $res = mysqli_query($conn, $sql);
   

        $sql = "INSERT INTO `wallet_address_history`(`waid`,`restoredate`,`restoreby`,`status`)
            VALUES ('$thisdwaid','$restoredate','$restoreby','restored')";
        $res = mysqli_query($conn, $sql);


     $sql =
            "INSERT INTO `user_activity`(`uid`,`remarks`,`activitydate`,`device`,`ip`,`status`)
                 VALUES ('$aid','$remarks','" .
            $restoredate .
            "','$device','$ip','restored')";
        $res = mysqli_query($conn, $sql); 


     }
    if($res)
    {

    $msg = "Wallet address successfully restored ";
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
