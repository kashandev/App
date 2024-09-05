<?php
// set code //
// include conn //
include_once "../conn/conn.php"; // this is used for include conn //
// end of include conn //

// initializing variables//
$invcode = "";
$thiscode = "";
$sql = "";
$res = "";
$row = "";

// end of initializing variables//

$sql =
    "SELECT invcode as invc from user_invitation_code where status = 'new' order by invcid desc limit 1 ";
$res = mysqli_query($conn, $sql);
if (mysqli_num_rows($res) == 0) {
    $sql =
        "SELECT invcode as invc from user_invitation_code where status = 'default' order by invcid desc limit 1 ";
    $res = mysqli_query($conn, $sql);
    while ($row = mysqli_fetch_array($res)) {
        $invcode = $row["invc"];
        $thiscode = $invcode;
    }
} else {
    $thiscode = "";
}

echo $thiscode;
