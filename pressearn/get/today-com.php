<?php

// today com //

// include conn //

include_once "../conn/conn.php"; // this is used for include conn //

// end of include conn //



// include date //

include_once "../date/date.php"; // this is used for include date//

// end of include date //



// variables //

$tlvid = "";

$uid = "";

$sql = "";

$res = "";

$tc = 0;

$thistc = 0;

$timestamp = "";

$today = "";

$timestamp = time();

$today = date("Y-m-d", $timestamp);

// end of variables //

if (isset($_POST["tlvid"])) {

    $tlvid = $_POST["tlvid"];

    $uid = $_POST["uid"];



    // tcom query //

    $sql =

        "SELECT  IFNULL(sum(tc),0) as tc from total_commission WHERE CAST(createdate as date) = '" .

        $today .

        "' AND uid = '" .

        $uid .

        "' AND tlvid = '" .

        $tlvid .

        "' AND iscancel = 0";

    // end of tcom query //

    // result //

    $res = mysqli_query($conn, $sql);

    // end of result //

    // check true condition //

    if ($row = mysqli_fetch_array($res)) {

        $tc = trim($row["tc"]);
        $thistc = floatval($tc);

    }

    // end of check true condition //

    else {

        //check false condition //

        $thistc = 0;

    } // end of check false condition //

    echo $thistc;

}

?>

