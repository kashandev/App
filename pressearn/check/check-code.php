<?php
// check code //
// include conn //
include_once "../conn/conn.php"; // this is used for include conn //
// end of include conn //
if (isset($_POST["refcode"]) == "") {
    $_POST["refcode"] = "";
}
if (isset($_POST["refcode"])) {
    // initializing variables//
    $remain = 0;
    $thisremain = 0;
    $sql = "";
    $res = "";
    $row = "";
    $msg = "";
    $thisstyle = "";
    $data = 0;
    $refcode = $_POST["refcode"];
    // end of initializing variables//

    $sql =
        "SELECT * from user_invitation_code where invcode = '".$refcode."' ";
    $res = mysqli_query($conn, $sql);
    if ($row = mysqli_fetch_array($res)) {
      $data = 1;
    }
     else{
      $data = 0;
     }
    echo $data;
}
?>
