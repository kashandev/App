<?php

// confirm order //

// include date //

include_once "../date/date.php"; // this is used for include date//

// end of include date //

// include ip //

include_once "../ip/ip.php"; // this is used for include ip //

// end of include ip //

// include conn //

include_once "../conn/conn.php"; // this is used for include conn //

// end of include conn //

$timestamp     = "";

$completedate  = "";

$createdate    = "";

$createtime    = "";

$tlvid         = "";

$uid           = "";

$oid           = "";

$noid          = "";

$blid          = "";

$coid          = "";

$sql           = "";

$res           = "";

$thistno       = "";

$thistrno      = "";

$thistco       = "";

$thistc        = "";

$thispc        = "";

$thisec        = "";

$uinvcid       = "";

$refcode       = "";

$thisro        = "";

$ordercode     = "";

$thisorderno   = "";

$prefix        = "";

$sufix         = "";

$orderno       = 0;

$digits        = 13;

$ibalance      = 0;

$rbalance      = 0;

$thisibalance  = 0;

$thistibalance = 0;

$thisrbalance  = 0;

$iscomplete    = 0;

$isclose       = 0;

$tco           = 0;

$today         = "";

$timestamp     = time();

$completedate  = date("Y-m-d h:i:s", $timestamp);

$createdate    = date("Y-m-d h:i:s ", $timestamp);

$today         = date("Y-m-d", $timestamp);

$createtime = date("h:i:s");

// end of variables //

if (isset($_POST["oid"])) {

    $oid      = $_POST["oid"];

    $tlvid    = $_POST["tlvid"];

    $uid      = $_POST["uid"];

    $noid     = $_POST["noid"];

    $thistno  = $_POST["thistno"];

    $thistrno = $_POST["thistrno"];

    $thistco  = $_POST["thistco"];

    $thistc   = $_POST["thistc"];

    $thispc   = $_POST["thispc"];

    $thisec   = $_POST["thisec"];

    $uinvcid = $_POST["uinvcid"];

    $refcode = $_POST["refcode"];

    $remarks  = "user order confirm";

       
    $sql =

    "SELECT (tno -  $thistco) as rno FROM no_of_orders WHERE uid = '" .

    $uid .

    "' AND tlvid = '" .

    $tlvid .

    "' AND noid = '" .

    $noid .

    "' AND iscomplete = 0 order by noid desc";

 $res = mysqli_query($conn, $sql);


if (mysqli_num_rows($res)) {

    if ($row = mysqli_fetch_array($res)) {

        $rno = $row['rno'];

        $thisrno = (int) $rno;


        if ($thisrno == 0) {

            $iscomplete = 1;
    
            $isclose    = 1;
    
        } else {
    
            $iscomplete = 0;
    
            $isclose    = 0;
    
        }

        $sql = "UPDATE `no_of_orders` set cno = '" . $thistco . "' , rno = '" . $thisrno . "', iscomplete = '" . $iscomplete . "' WHERE uid = '" . $uid . "' AND tlvid = '" . $tlvid . "' AND noid = '" . $noid . "' AND iscomplete = 0";

        $res = mysqli_query($conn, $sql);

    }

}
    

    $sql = "SELECT bl.blid,bl.ibalance,sum(bl.rbalance) as rbalance FROM balance as bl WHERE bl.uid = '" . $uid . "' AND bl.isapprove = 1 AND bl.isclose = 0 LIMIT 1";

    $res = mysqli_query($conn, $sql);

    if ($row = mysqli_fetch_array($res)) {

        $blid         = $row['blid'];

        $ibalance     = $row['ibalance'];

        $rbalance     = $row['rbalance'];

        $thisibalance = (float) ($ibalance);

        $thisrbalance = (float) ($rbalance);

    } else {

        $thisibalance = 0;

        $thisrbalance = 0;

    }

    

    $thistibalance = (float) ($thisibalance + $thistc);

    $thisrbalance  = (float) ($thisrbalance + $thistc);

    

    $sql = "UPDATE balance set ibalance = '" . $thistibalance . "', rbalance = '" . $thisrbalance . "' where uid = '" . $uid . "' and isclose = 0";

    $res = mysqli_query($conn, $sql);

    $sql = "INSERT INTO `balance_history`(`uid`,`blid`,`balance`,`createdate`,`status`)

          VALUES ('$uid','$blid','$thistibalance','$createdate','created')";

    $res = mysqli_query($conn, $sql);

    

    $sql = "UPDATE `orders` set iscomplete = 1, completedate  = '" . $completedate . "', status ='completed' WHERE uid = '" . $uid . "' AND oid = '" . $oid . "' AND iscomplete = 0 AND iscancel = 0 AND isclose = 0 AND CAST(orderdate as date) = '" . $today . "'";

    $res = mysqli_query($conn, $sql);

    

    

    $sql = "UPDATE `orders` set isclose = '" . $isclose . "' WHERE uid = '" . $uid . "' AND iscomplete = 1 AND iscancel = 0 AND isclose = 0 AND CAST(orderdate as date) = '" . $today . "'";

    $res = mysqli_query($conn, $sql);

    

    

    $sql = "UPDATE `product_images` set iscomplete = 1, completedate  = '" . $completedate . "', status ='completed' WHERE uid = '" . $uid . "' AND oid = '" . $oid . "' AND iscomplete = 0 AND iscancel = 0 AND isclose = 0 AND CAST(createdate as date) = '" . $today . "'";

    $res = mysqli_query($conn, $sql);

    

    $sql = "UPDATE `product_images` set isclose = '" . $isclose . "' WHERE uid = '" . $uid . "'  AND iscomplete = 1 AND iscancel = 0 AND isclose = 0 AND CAST(createdate as date) = '" . $today . "'";

    $res = mysqli_query($conn, $sql);

    

    $sql = "INSERT INTO `orders_history`(`uid`,`tlvid`,`oid`,`createdate`,`status`)

        VALUES ('$uid','$tlvid','$oid','$createdate','completed')";

    $res = mysqli_query($conn, $sql);




    $sql = "INSERT INTO `user_commission`(`uid`,`tlvid`,`invcid`,`refcode`,`nod`,`tc`,`pc`,`ucomm`,`createdate`,`iscancel`)

        VALUES ('$uid','$tlvid','$uinvcid','$refcode','$thistco','$thistc','$thispc','$thisec','$createdate',0)";

    $res = mysqli_query($conn, $sql);





    $sql = "INSERT INTO `total_commission`(`uid`,`tlvid`,`refcode`,`tc`,`nc`,`createdate`,`iscancel`)

        VALUES ('$uid','$tlvid','$refcode','$thistc','$thisec','$createdate',0)";

    $res = mysqli_query($conn, $sql);



    

    $sql = "INSERT INTO `user_activity`(`uid`,`remarks`,`activitydate`,`device`,`ip`,`status`)

                 VALUES ('$uid','$remarks','" . $createdate . "','$device','$ip','created')";

    $res = mysqli_query($conn, $sql);

}

?>