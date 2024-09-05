<?php

// get balance //

// include conn //

include_once('../conn/conn.php'); // this is used for include conn //

// end of include conn //

// initializing variables//

$invcode = "";

$thiscode = "";

$sql = "";

$res = "";

$row = "";

$thislink = "";

$data = "";

$avbal = 0;

$thisavbal= 0;



// end of initializing variables//



if (isset($_POST["uid"]) == "") {

    $_POST["uid"] = "";

}



if (isset($_POST["uid"])) {

    $uid = $_POST["uid"];

}



if ($uid != '') {

 $sql = "SELECT IFNULL(sum(bl.rbalance),0) as avbal from balance as bl WHERE bl.uid = '".$uid."' and bl.isapprove = 1 and bl.isclose = 0 LIMIT 1";

}

$res = mysqli_query($conn, $sql);

if ($row = mysqli_fetch_array($res)) {

    $avbal = $row['avbal'];

    $thisavbal = abs($avbal);

} else {

   $thisavbal = 0;

}



echo $thisavbal;



