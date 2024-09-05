<?php

// yesterday com //

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

$yc = 0;

$thisyc = 0;

$tcomdate = "";

$yesterday = "";

$timestamp = time();

$tcomdate = date("Y-m-d", $timestamp);

$yesterday = date("Y-m-d", strtotime($tcomdate . "-1 days"));

// end of variables //

if (isset($_POST["tlvid"])) {

    $tlvid = $_POST["tlvid"];

    $uid = $_POST["uid"];

    // ycom query //



    $sql =

        "SELECT  IFNULL(sum(tc),0) as yc from total_commission WHERE CAST(createdate as date) = '" .

        $yesterday .

        "' AND uid = '" .

        $uid .

        "' AND tlvid = '" .

        $tlvid .

        "' AND iscancel = 0";


    // end of ycom query //

    // result //

    $res = mysqli_query($conn, $sql);

    // end of result //

    // check true condition //

    if ($row = mysqli_fetch_array($res)) {

        $yc = $row["yc"];

        $thisyc = floatval($yc);

    }

    // end of check true condition //

    else {

        //check false condition //

        $thisyc = 0;

    } // end of check false condition //

    echo $thisyc;

}

?>

