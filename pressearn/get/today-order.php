<?php

// today order //

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

$tord = 0;

$thistord = 0;

$timestamp = "";

$today = "";

$timestamp  = time();

$today   = date("Y-m-d", $timestamp);

// end of variables //

if (isset($_POST["tlvid"]))

{

    $tlvid = $_POST["tlvid"];

    $uid = $_POST["uid"];

    // check tordday order query //

    $sql = "SELECT IFNULL(count(nod),0) as tord from orders WHERE CAST(orderdate as date) = '".$today."' and uid = '" . $uid . "' AND tlvid = '" . $tlvid . "' AND iscancel = 0";

    // end of check tordday order query //

    // result //

    $res = mysqli_query($conn, $sql);

    // end of result //

    // check true condition //

    if ($row = mysqli_fetch_array($res))

    {

        $tord = $row['tord'];

        $thistord = intval($tord);

    } // end of check true condition //

    else

    { //check false condition //

        $thistord = 0;

    } // end of check false condition //

    echo $thistord;
}
?>