<?php

// save deposit //

// include date //

include_once "../date/date.php"; // this is used for include date//

// end of include date //

// include ip //

include_once "../ip/ip.php"; // this is used for include ip //

// end of include ip //

// include conn //

include_once "../conn/conn.php"; // this is used for include conn //

// end of include conn //

$data = [];

$msg = "";

$btn = "";

$timestamp = "";

$createdate = "";

$dpid = "";

$uid = "";

$tid = "";

$wlid = "";

$txid = "";

$utxid = "";

$utxtid = "";

$tpmid = "";

$waid = "";

$depositby = "";

$waddress = "";

$tximage = "";

$deposit = "";

$refcode = "";

$sql = "";

$res = "";

$timestamp = time();

$createdate = date("Y-m-d h:i:s", $timestamp);

// end of variables //

if (isset($_POST["uid"])) {

    $uid = $_POST["uid"];

    $utmid =$_POST['utmid'];

    $uinvcid =$_POST['uinvcid'];

    $depositby = $_POST["uname"];

    $waid = $_POST["waid"];

    $tpmid = $_POST["tpmid"];

    $refcode = $_POST["myrefcode"];

    $waddress = $_POST["waddress"];

    $txid = $_POST["txid"];

    $utxid = md5($uid);

    $tximage = $_POST["tximg"];

    $deposit = $_POST['deposit'];

    $remarks = "user deposit";



    $sql = "INSERT INTO `deposite`( `uid`, `waid`, `tpmid`,`refcode`,`recvadd`,`txid`,`utxid`,`txcrtf`,`deposit`,`depositdate`,`depositby`)

        VALUES ('$uid','$waid','$tpmid','$refcode','$waddress','$txid','$utxid','$tximage','$deposit','$createdate','$depositby')";



    if (mysqli_query($conn, $sql)) {

        $sql = "SELECT LAST_INSERT_ID()";

        $res = mysqli_query($conn, $sql);

        $row = mysqli_fetch_array($res);

        $dpid = $row[0];



        $sql = "INSERT INTO `wallet`( `uid`,`waid`,`tpmid`,`dpid`,`txid`,`utxid`,`wallet`,`createdate`,`createby`)

          VALUES ('$uid','$waid','$tpmid','$dpid','$txid','$utxid','$deposit','$createdate','$depositby');";



        $res = mysqli_query($conn, $sql);

        $sql = "SELECT LAST_INSERT_ID()";

        $res = mysqli_query($conn, $sql);

        $row = mysqli_fetch_array($res);

        $wlid = $row[0];



        $sql = "INSERT INTO `team_deposit`(`tmid`,`uid`,`invcid`,`dpid`,`refcode`,`amount`,`createdate`,`remarks`)

                 VALUES ('$utmid','$uid','$uinvcid','$dpid','$refcode','$deposit','"

            . $createdate

            . "','team deposit')";

        $res = mysqli_query($conn, $sql);



        $sql = "INSERT INTO `deposite_wallet`( `uid`, `waid`, `tpmid`,`dpid`,`deposit`,`createdate`,`createby`)

        VALUES ('$uid','$waid','$tpmid','$dpid','$deposit','$createdate','$depositby')";



        $res = mysqli_query($conn, $sql);   



        $sql = "INSERT INTO `transaction`(`uid`,`tpmid`,`dpid`,`wlid`,`transaction`,`transactiondate`)

            VALUES ('$uid','$tpmid','$dpid','$wlid','$deposit','$createdate')";

        $res = mysqli_query($conn, $sql);

        $sql = "SELECT LAST_INSERT_ID()";

        $res = mysqli_query($conn, $sql);

        $row = mysqli_fetch_array($res);

        $tid = $row[0];



        $sql = "INSERT INTO `transaction_activity`(`uid`,`tid`,`remarks`,`activitydate`)

            VALUES ('$uid','$tid','$remarks','$createdate')";

        $res = mysqli_query($conn, $sql);



        $sql =

            "INSERT INTO `user_activity`(`uid`,`remarks`,`activitydate`,`device`,`ip`,`status`)

                 VALUES ('$uid','$remarks','" .

            $createdate .

            "','$device','$ip','deposit')";

        $res = mysqli_query($conn, $sql);





        $msg = "Deposit Successfully";

}

    else {

        $msg = "Failed";

    }

    $data = [

        "msg" => $msg,

    ];

 echo json_encode($data);

}

?>

