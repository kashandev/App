<?php

// save order //

// include date //

include_once "../date/date.php"; // this is used for include date//

// end of include date //

// include ip //

include_once "../ip/ip.php"; // this is used for include ip //

// end of include ip //

// include conn //

include_once "../conn/conn.php"; // this is used for include conn //

// end of include conn //

$timestamp = "";

$orderdate = "";

$createdate = "";

$ordertime = "";

$createtime = "";

$tlvid = "";

$uid = "";

$oid = "";

$coid = "";

$uinvcid = "";

$refcode = "";

$coid = "";

$sql = "";

$res = "";

$thistco = "";

$thistc = "";

$thispc = "";

$thisec = "";

$thisno = "";

$ordercode = "";

$thisorderno = "";

$thispid = "";

$thispname = "";

$thispimg = "";

$prefix = "";

$sufix = "";

$orderno = 0;

$torderno = 0;

$digits = 10;

$ibalance = 0;

$rbalance = 0;

$thisibalance = 0;

$thistibalance = 0;

$thisrbalance = 0;

$x = 0;

$pid = [];

$pname = [];

$pimg = [];

$data = [];

$timestamp = time();

$orderdate = date("Y-m-d", $timestamp);

$createdate = date("Y-m-d h:i:s ", $timestamp);

$ordertime = date("h:i:s");

$createtime = date("h:i:s");

// end of variables //

if (isset($_POST["tlvid"])) {

    $tlvid = $_POST["tlvid"];

    $uid = $_POST["uid"];

    $thistco = $_POST["thistco"];

    $thistc = $_POST["thistc"];

    $thispc = $_POST["thispc"];

    $thisec = $_POST["thisec"];

    $uinvcid = $_POST["uinvcid"];

    $refcode = $_POST["refcode"];

    $remarks = "user order";

    $ordercode = substr(str_shuffle("012345678910112"), 0, 13);



    $sql =

        "SELECT COUNT(ono)+1 as ono from orders WHERE CAST(orderdate as date) = '" .

        $orderdate .

        "' AND uid = '" .

        $uid .

        "' AND tlvid = '" .

        $tlvid .

        "' AND iscomplete = 0 AND iscancel = 0 AND isclose = 0";

    $res = mysqli_query($conn, $sql);

    if ($row = mysqli_fetch_array($res)) {

        $orderno = $row["ono"];

    } else {

        $orderno = 0;

    }

    $sufix = $ordercode . "" . $orderno;

    $prefix = "N0";

    $thisorderno = $prefix . $sufix;



    $sql = "INSERT INTO `orders`(`uid`,`tlvid`,`ono`,`nod`,`amount`,`orderdate`,`ordertime`,`iscomplete`,`iscancel`,`isclose`,`status`,`remarks`)

        VALUES ('$uid','$tlvid','$thisorderno','$thistco','$thisec','$orderdate','$ordertime',0,0,0,'pending','$remarks')";

    $res = mysqli_query($conn, $sql);

    $sql = "SELECT LAST_INSERT_ID()";

    $res = mysqli_query($conn, $sql);

    $row = mysqli_fetch_array($res);

    $oid = $row[0];



    $sql = "INSERT INTO `orders_history`(`uid`,`tlvid`,`oid`,`createdate`,`status`)

        VALUES ('$uid','$tlvid','$oid','$createdate','pending')";

    $res = mysqli_query($conn, $sql);



    $sql =

        "SELECT nod as tono from orders WHERE CAST(orderdate as date) = '" .

        $orderdate .

        "' and uid = '" .

        $uid .

        "' AND tlvid = '" .

        $tlvid .

        "' AND oid = '" .

        $oid .

        "' AND iscomplete = 0 AND iscancel = 0 AND isclose = 0 ";

    $res = mysqli_query($conn, $sql);

    if ($row = mysqli_fetch_array($res)) {

        $torderno = $row["tono"];

    } else {

        $torderno = 0;

    }



    $sql =

        "SELECT * from products WHERE iscancel = 0 AND isclose = 0 AND pid = '" .

        $torderno .

        "'";



    $res = mysqli_query($conn, $sql);

    if (mysqli_num_rows($res)) {

        while ($row = mysqli_fetch_array($res)) {

            $pid[$x] = $row["pid"];

            $pname[$x] = $row["pname"];

            $pimg[$x] = $row["pimg"];

            $x++;

        }

    }

    for ($i = 0; $i < count($pid); $i++) {

        $thispid = $pid[$i];

        $thispname = $pname[$i];

        $thispimg = $pimg[$i];

        if ($thispid == $torderno) {

            $sql = "INSERT INTO `product_images`(`uid`,`tlvid`,`oid`,`pid`,`pname`,`pimg`,`createdate`,`iscomplete`,`iscancel`,`isclose`,`status`)

        VALUES ('$uid','$tlvid','$oid','$thispid','$thispname','$thispimg','$createdate',0,0,0,'pending')";



            $res = mysqli_query($conn, $sql);

        }

    }

    $sql =

        "SELECT ifnull(count(ec),0) as tco from commission WHERE CAST(commdate as date) = '" .

        $createdate .

        "' AND uid = '" .

        $uid .

        "' AND tlvid = '" .

        $tlvid .

        "'";

    $res = mysqli_query($conn, $sql);

    if ($row = mysqli_fetch_array($res)) {

        $tco = $row["tco"];

    } else {

        $tco = 0;

    }



    if ($tco == 0) {

        $sql = "INSERT INTO `commission`(`uid`,`tlvid`,`nod`,`tc`,`pc`,`ec`,`commdate`,`status`)

        VALUES ('$uid','$tlvid','$thistco','$thistc','$thispc','$thisec','$createdate','created')";

        $res = mysqli_query($conn, $sql);

        $sql = "SELECT LAST_INSERT_ID()";

        $res = mysqli_query($conn, $sql);

        $row = mysqli_fetch_array($res);

        $coid = $row[0];

    }



    $sql = "INSERT INTO `commission_history`(`uid`,`tlvid`,`coid`,`oid`,`ono`,`nod`,`amount`,`tc`,`pc`,`ec`,`createdate`,`createtime`,`iscancel`,`status`)

        VALUES ('$uid','$tlvid','$coid','$oid','$thisorderno','$thistco','$thistc','$thistc','$thispc','$thisec','$createdate','$createtime',0,'created')";

    $res = mysqli_query($conn, $sql);



    $sql =

        "INSERT INTO `user_activity`(`uid`,`remarks`,`activitydate`,`device`,`ip`,`status`)

                  VALUES ('$uid','$remarks','" .

        $createdate .

        "','$device','$ip','created')";

    $res = mysqli_query($conn, $sql);



    $data = [

        "oid" => $oid,

        "ono" => $torderno,

    ];

    echo json_encode($data);

}

?>

