<?php
// get user //
// include conn //
include_once('../conn/conn.php'); // this is used for include conn //
// end of include conn //
// initializing variables//
$invcode = "";
$thiscode = "";
$sql = "";
$res = "";
$row = "";
$thislink = "";
$data = [];

// end of initializing variables//

if (isset($_POST["uid"]) == "") {
    $_POST["uid"] = "";
}

if (isset($_POST["uid"])) {
    $uid = $_POST["uid"];
}

if ($uid != '') {
    $sql = "SELECT * from users WHERE users.userid = '".$uid."' and users.isdeleted = 0 LIMIT 1";
}
$res = mysqli_query($conn, $sql);
if ($row = mysqli_fetch_array($res)) {
   $data[] = $row;
} else {
   $data[] = "";
}

echo json_encode($data);

