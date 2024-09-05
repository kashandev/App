<?php
// attempted passcode //
// include conn //
include_once "../conn/conn.php"; // this is used for include conn //
// end of include conn //
// include date //
include_once "../date/date.php"; // this is used for include date//
// end of include date //

// include ip //
include_once "../ip/ip.php"; // this is used for include ip //
// end of include ip //

if (isset($_POST["uid"]) == "") {
    $_POST["uid"] = "";
}
if (isset($_POST["tpass"]) == "") {
    $_POST["tpass"] = "";
}
if (isset($_POST["uid"])) {
    // initializing variables//
    $sql = "";
    $res = "";
    $row = "";
    $msg = "";
    $tpid = "";
    $passcode = "";
    $remarks = "";
    $createdate = "";
    $data = 0;
    $timestamp = time();
    $createdate = date("Y-m-d h:i:s", $timestamp);

    $uid = $_POST["uid"];
    $tpass = $_POST["tpass"];
    $remarks = "user attempted passcode";
    // end of initializing variables//
     $sql = "SELECT * from user_transaction_passcode as utc where utc.uid = '" . $uid . "' and utc.passcode = '" . $tpass . "' limit 1";
     $res = mysqli_query($conn, $sql);
    if ($row = mysqli_fetch_array($res)) {
        $tpid = $row['tpid'];
        $passcode = $row['passcode'];
        if ($tpass == $passcode) {           
            $sql = "UPDATE user_transaction_passcode set status = 'attempted' ";

            $res = mysqli_query($conn, $sql);

            $sql =
                "INSERT INTO `user_attempt_passcode`(`uid`,`tpid`,`attemptdate`,`isattempt`,`status`)
                 VALUES ('$uid','$tpid','" .
                $createdate .
                "',1,'attempted')";
            $res = mysqli_query($conn, $sql);
            $sql =
                "INSERT INTO `user_activity`(`uid`,`remarks`,`activitydate`,`device`,`ip`,`status`)
                 VALUES ('$uid','$remarks','" .
                $createdate .
                "','$device','$ip','attempted')";
            $res = mysqli_query($conn, $sql);      

            $data = 1;
        }
       } else {
        $data = 0;
    }
    echo $data;
}
?>
