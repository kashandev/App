<?php
// count limit //
// include conn //
include_once "../conn/conn.php"; // this is used for include conn //
// end of include conn //
if (isset($_POST["refcode"]) == "") {
    $_POST["refcode"] = "";
}
if (isset($_POST["refcode"])) {
    // initializing variables//
    $refcode = $_POST["refcode"];
    $invcid = "";
    $limit = 0;
    $used = 0;
    $remain = 0;
    $thislimit = 0;
    $thisused = 0;
    $thisremain = 0;
    $sql = "";
    $res = "";
    $row = "";
    $msg = "";
    $thisstyle = "";
    $data = [];
    // end of initializing variables//

    $sql =
        "SELECT invcid as incvid,tlimit as lmt,(SELECT count(user_attempt_invitation_code.used)+1 from user_attempt_invitation_code WHERE user_attempt_invitation_code.invcid = user_invitation_code.invcid LIMIT 1) as used from user_invitation_code where invcode = '" .
        $refcode .
        "' ";

    $res = mysqli_query($conn, $sql);
    if ($row = mysqli_fetch_array($res)) {
        $incvid = $row["incvid"];
        $limit =  (int)($row["lmt"]);
        $used = (int) ($row["used"]);
        $remain = (int) ($limit - $used);
        $thislimit = abs($limit);
        $thisused = abs($used);
        $thisremain = abs($remain);

        $data = [
            "invcid" => $incvid,
            "limit" => $limit,
            "used" => $thisused,
            "remain" => $thisremain,
        ];
    } else {
        $invcid = "";
        $limit = 0;
        $thisused = 0;
        $thisremain = 0;
        $msg = "";
        $data = [
            "invcid" => $invcid,
            "limit" => $limit,
            "used" => $thisused,
            "remain" => $thisremain,
        ];
    }
    echo json_encode($data);
}
?>
