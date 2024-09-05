<?php
// check limit //
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
    $data = false; 
    $refcode = $_POST["refcode"];
    // end of initializing variables//
    $sql =
        "SELECT invcid as incvid,tlimit as lmt,(SELECT user_attempt_invitation_code.remain from user_attempt_invitation_code WHERE user_attempt_invitation_code.invcid = user_invitation_code.invcid ORDER BY atinvcid DESC LIMIT 1) as remain from user_invitation_code where invcode = '" .
        $refcode .
        "' ";
    $res = mysqli_query($conn, $sql);
    if ($row = mysqli_fetch_array($res)) {
        $remain = $row["remain"];
        }
    if($remain == '')
     {
        $thisremain = ""; 
        $data = false;
     }else{
       $thisremain = abs((int)($remain));
        if($thisremain == 0){
         $data = true;
     }
    echo $data;
}
}
?>
