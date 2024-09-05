<?php
// cancel order //
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
$canceldate    = "";
$createdate    = "";
$ordertime     = "";
$tlvid         = "";
$uid           = "";
$oid           = "";
$noid          = "";
$blid          = "";
$sql           = "";
$res           = "";
$thistno       = "";
$thistco       = "";
$thistc        = "";
$thispc        = "";
$thisec        = "";
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
$timestamp     = time();
$canceldate    = date("Y-m-d h:i:s", $timestamp);
$createdate    = date("Y-m-d h:i:s", $timestamp);
// end of variables //
if (isset($_POST["oid"])) {
    $oid     = $_POST["oid"];
    $tlvid   = $_POST["tlvid"];
    $uid     = $_POST["uid"];
    $remarks = "user order cancel";
    
    $sql = "UPDATE `orders` set iscancel = 1, canceldate  = '" . $canceldate . "', status ='cancelled' WHERE uid = '" . $uid . "' AND oid = '" . $oid . "' AND iscomplete = 0 AND iscancel = 0 AND isclose = 0 ";
    $res = mysqli_query($conn, $sql);
    
    $sql = "UPDATE `product_images` set iscancel = 1, canceldate  = '" . $canceldate . "', status ='cancelled' WHERE uid = '" . $uid . "' AND oid = '" . $oid . "' AND iscomplete = 0 AND iscancel = 0 AND isclose = 0";
    $res = mysqli_query($conn, $sql);
    
    $sql = "UPDATE `commission_history` set iscancel = 1, canceldate  = '" . $canceldate . "', status ='cancelled'  WHERE date(createdate) =  date(now()) AND uid = '" . $uid . "' AND tlvid = '" . $tlvid . "' AND oid = '" . $oid . "' ";
    $res = mysqli_query($conn, $sql);
    
    $sql = "INSERT INTO `orders_history`(`uid`,`tlvid`,`oid`,`createdate`,`status`)
        VALUES ('$uid','$tlvid','$oid','$createdate','cancelled')";
    $res = mysqli_query($conn, $sql);
    
    $sql = "INSERT INTO `user_activity`(`uid`,`remarks`,`activitydate`,`device`,`ip`,`status`)
                 VALUES ('$uid','$remarks','" . $createdate . "','$device','$ip','created')";
    $res = mysqli_query($conn, $sql);
}
?>