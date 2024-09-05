<?php
// check password //
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
if (isset($_POST["upass"]) == "") {
    $_POST["upass"] = "";
}
if (isset($_POST["uid"])) {
    // initializing variables//
    $sql = "";
    $res = "";
    $row = "";
    $msg = "";
    $decpass = "";
    $data = 0; 
    $uid = $_POST["uid"];
    $upass = $_POST["upass"];
    // end of initializing variables//
    $sql = "SELECT * from users as u where u.userid = '" . $uid . "' and u.decpass = '" . $upass . "' limit 1";
    $res = mysqli_query($conn, $sql);
    if ($row = mysqli_fetch_array($res)) {
        $decpass = $row['decpass'];
        if ($upass == $decpass) {
            $data = 1;
        }
    } else {
        $data = 0;
    }
    echo $data;
}
?>
