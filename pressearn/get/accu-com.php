<?php

// accu com //

// include conn //

include_once "../conn/conn.php"; // this is used for include conn //

// end of include conn //

// variables //

$uid = "";

$sql = "";

$res = "";

$accuc = 0;

$thisaccuc = 0;

// end of variables //

if (isset($_POST["uid"])) {

    $uid = $_POST["uid"];



    // tcom query //

    $sql =

        "SELECT  IFNULL(sum(tc),0) as accuc from total_commission WHERE uid = '" .

        $uid .

        "' AND iscancel = 0";

    // end of tcom query //

    // result //

    $res = mysqli_query($conn, $sql);

    // end of result //

    // check true condition //

    if ($row = mysqli_fetch_array($res)) {

        $accuc = $row["accuc"];

        $thisaccuc = floatval($accuc);

    }
    // end of check true condition //

    else {

        //check false condition //

        $thisaccuc = 0;

    } // end of check false condition //

    echo $thisaccuc;

}

?>

