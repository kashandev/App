<?php

// team com //

// include conn //

include_once "../conn/conn.php"; // this is used for include conn //

// end of include conn //

// include date //

include_once "../date/date.php"; // this is used for include date//

// end of include date //



// variables //



$uid = "";

$tlvid = "";

$refcode = "";

$sql = "";

$res = "";

$tmid = [];

$tuid = [];

$refc = [];

$retc = [];

$data = [];

$tcom = [];

$ulevel = "";

$ultvid = "";

$tlid = "";

$x = 0;

$y = 0;

$thistmid = "";

$thistuid = "";

$thisrefcode = "";

$thisretcode = "";

$thistcom = 0;

$timestamp = "";

$tc = "";

$today = "";

$timestamp = time();

$today = date("Y-m-d", $timestamp);

// end of variables //



if (isset($_POST["uid"]) == "") {

    $_POST["uid"] = "";

}



if (isset($_POST["tlvid"]) == "") {

    $_POST["tlvid"] = "";

}



if (isset($_POST["refcode"]) == "") {

    $_POST["refcode"] = "";

}



if (isset($_POST["uid"])) {

    $uid = $_POST["uid"];

}



if (isset($_POST["tlvid"])) {

    $tlvid = $_POST["tlvid"];

}



if (isset($_POST["refcode"])) {

    $refcode = $_POST["refcode"];

}



$sql =

    "SELECT level as ulevel from user_invitation_code where invcode = '" .

    $refcode .

    "' and status = 'new' limit 1";

$res = mysqli_query($conn, $sql);



if (mysqli_num_rows($res)) {

    while ($row = mysqli_fetch_array($res)) {

        $ulevel = $row["ulevel"];

    }

} else {

    $ulevel = "";

}



$sql =

    "SELECT teams.* FROM teams WHERE teams.refcode = '" .

    $refcode .

    "' AND levelfrom = '" .

    $ulevel .

    "' ";

$res = mysqli_query($conn, $sql);



if (mysqli_num_rows($res)) {

    while ($row = mysqli_fetch_array($res)) {

        $tmid[$x] = $row["tmid"];

        $tuid[$x] = $row["uid"];

        $refc[$x] = $row["refcode"];

        $retc[$x] = $row["retcode"];



        $x++;

    }

} else {

    $tmid[$x] = "";

    $tuid[$x] = "";

    $refc[$x] = "";

    $retc[$x] = "";

}



foreach ($tuid as $key => $thistuid) {

    $thistuid = $tuid[$key];

    $thisrefcode = $refc[$key];

    $thisretcode = $retc[$key];



    // tcom query //

    if ($tlvid == "") {

        $sql =

            "SELECT ROUND(SUM(tc),2) as tc FROM total_commission WHERE iscancel = 0 AND refcode = '" .

            $thisretcode .

            "'";



        // result //

        $res = mysqli_query($conn, $sql);

        // end of result //



        if (mysqli_num_rows($res)) {

            // check true condition //

            while ($col = mysqli_fetch_array($res)) {

                $tc = $col["tc"];

                $thistcom += floatval($tc);

            }

            // end of check true condition /

        } else {

            //check false condition //

            $thistcom = 0;

        } // end of check false condition //

    }

}

echo $thistcom;

?>

