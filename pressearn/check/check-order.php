<?php

// check order //

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

$timestamp = "";

$today = "";

$timestamp     = time();

$today      = date("Y-m-d", $timestamp);

$yesterday = date('Y-m-d', strtotime($today . '-1 days'));

$check = 0;

// end of variables //

if (isset($_POST["tlvid"])) {

    $tlvid = $_POST["tlvid"];

    $uid = $_POST["uid"];

    // check today order query //



      $sql =

        "SELECT isclose from orders WHERE uid = '" .

        $uid .

        "' AND tlvid = '" .

        $tlvid .

        "' AND isclose = 1 AND CAST(orderdate as date) = '".$today."'";  

    // result //

    $res = mysqli_query($conn, $sql);

    // end of result //

    // check true condition //

    if ($row = mysqli_fetch_array($res)) {

        $check = 1;

    }

    // end of check true condition //

    else {

        //check false condition //

        $check = 0;

        // check yesterday order query //

    } // end of check false condition //

    echo $check;

}

?>

