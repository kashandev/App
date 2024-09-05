<?php

// save withdrawal //

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

$wid = "";

$uid = "";

$tid = "";

$wlid = "";

$txid = "";

$utxid = "";

$tpmid = "";

$waid = "";

$withdrawalby = "";

$waddress = "";

$tximage = "";

$amount = "";

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

    $withdrawalby = $_POST["uname"];

    $waid = $_POST["waid"];

    $tpmid = $_POST["tpmid"];

    $refcode = $_POST["myrefcode"];

    $txid = $_POST["txid"];

    $utxid = md5($uid);

    $realname = $_POST['realname'];

    $email = $_POST['email'];

    $phone = $_POST['phone'];

    $address = $_POST['address'];

    $withdrawal = $_POST['withdrawal'];

    $remarks = "user withdrawal";



    $sql = "INSERT INTO `withdrawal`( `uid`, `waid`, `tpmid`,`refcode`,`txid`,`utxid`,`realname`,`email`,`phone`,`address`,`withdrawal`,`withdrawaldate`,`withdrawalby`)

        VALUES ('$uid','$waid','$tpmid','$refcode','$txid','$utxid','$realname','$email','$phone','$address','$withdrawal','$createdate','$withdrawalby')";



    if (mysqli_query($conn, $sql)) {



        $sql = "SELECT LAST_INSERT_ID()";

        $res = mysqli_query($conn, $sql);

        $row = mysqli_fetch_array($res);

        $wtid = $row[0];



    $sql = "INSERT INTO `wallet`( `uid`,`waid`,`tpmid`,`wtid`,`txid`,`utxid`,`wallet`,`createdate`,`createby`)

          VALUES ('$uid','$waid','$tpmid','$wtid','$txid','$utxid','$withdrawal','$createdate','$withdrawalby');";



        $res = mysqli_query($conn, $sql);

        $sql = "SELECT LAST_INSERT_ID()";

        $res = mysqli_query($conn, $sql);

        $row = mysqli_fetch_array($res);

        $wlid = $row[0];



        $sql = "INSERT INTO `team_withdrawal`(`tmid`,`uid`,`invcid`,`wtid`,`refcode`,`amount`,`createdate`,`remarks`)

                 VALUES ('$utmid','$uid','$uinvcid','$wtid','$refcode','$withdrawal','"

            . $createdate

            . "','team withdrawal')";

        $res = mysqli_query($conn, $sql); 





        $sql = "INSERT INTO `withdrawal_wallet`( `uid`, `waid`, `tpmid`,`wtid`,`withdrawal`,`createdate`,`createby`)

        VALUES ('$uid','$waid','$tpmid','$wtid','$withdrawal','$createdate','$withdrawalby')";

        $res = mysqli_query($conn, $sql);  





        $sql = "INSERT INTO `transaction`(`uid`,`tpmid`,`wtid`,`wlid`,`transaction`,`transactiondate`)

            VALUES ('$uid','$tpmid','$wtid','$wlid','$withdrawal','$createdate')";

        $res = mysqli_query($conn, $sql);

        $sql = "SELECT LAST_INSERT_ID()";

        $res = mysqli_query($conn, $sql);

        $row = mysqli_fetch_array($res);

        $tid = $row[0];





        $sql = "INSERT INTO `transaction_activity`(`uid`,`tid`,`remarks`,`activitydate`)

            VALUES ($uid,$tid,'$remarks','$createdate')";

        $res = mysqli_query($conn, $sql);



        $sql =

            "INSERT INTO `user_activity`(`uid`,`remarks`,`activitydate`,`device`,`ip`,`status`)

                 VALUES ($uid,'$remarks','" .

            $createdate .

            "','$device','$ip','withdrawal')";

        $res = mysqli_query($conn, $sql);



        $msg = " Withdrawal Successfully ";

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

