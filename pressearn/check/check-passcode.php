<?php
// check passcode //
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
    $passcode = "";
    $data = 0; 
    $uid = $_POST["uid"];
    $tpass = $_POST["tpass"];
    // end of initializing variables//
    $sql = "SELECT * from user_transaction_passcode as utc where utc.uid = '" . $uid . "' and utc.passcode = '" . $tpass . "' limit 1";
    $res = mysqli_query($conn, $sql);
    if ($row = mysqli_fetch_array($res)) {
        $passcode = $row['passcode'];
        if ($tpass == $passcode) {
            $data = 1;
        }
    } else {
        $data = 0;
    }
    echo $data;
}
?>
