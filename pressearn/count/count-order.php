<?php

// count order //

// include conn //

include_once "../conn/conn.php"; // this is used for include conn //

// end of include conn //

// variables //

$tlvid = "";

$uid = "";

$sql = "";

$res = "";

$tord = 0;

$thistord = 0;

$thisord = "";

// end of variables //

if (isset($_POST["tlvid"])) {

    $tlvid = $_POST["tlvid"];

    $uid = $_POST["uid"];

    // count yesterday order query //



    // //  count today order query //

    $sql =

        "SELECT COUNT(nod)+1 as tord from orders WHERE iscancel = 0 AND isclose = 0 AND uid = '" .

        $uid .

        "'  AND tlvid = '" .

        $tlvid .

        "'";

    // end of count today order query //

    // result //

    $res = mysqli_query($conn, $sql);

    // end of result //

    // check true condition //

    if ($row = mysqli_fetch_array($res)) {

        $tord = $row["tord"];

        $thistord = intval($tord);

        $thisord = trim($thistord);

    }

    // end of check true condition //

    else {

        //check false condition //

        $thistord = 0;

        $thisord = "";

    } // end of check false condition //

    echo $thisord;

}
?>

