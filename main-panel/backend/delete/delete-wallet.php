<?php

// approve wallet //

// include session //

include_once "../session/session.php"; // this is used for include session//

// end of include session //

// include ip //

include_once "../ip/ip.php"; // this is used for include ip //

// end of include ip //

// include conn //

include_once('../../conn/conn.php'); // this is used for include conn //

// end of include conn //



$data = [];

$msg = "";

$btn = "";

$timestamp = "";

$deletedate = "";

$date = "";

$dpid = "";

$uid = "";

$uname = "";

$approveby = "";

$sql = "";

$res = "";

$thiswaid = '';

$timestamp = time();

$deletedate = date("Y-m-d h:i:s", $timestamp);

$date = date("d-m-Y");

// end of variables //

if (isset($_POST["waid"])) {

    $waid = $_POST["waid"];

    $aid = $_POST["aid"];

    $deleteby = $_POST["uname"];

    $remarks = "delete wallet address";

     foreach ($waid as $key => $thiswaid) {

       $thiswaid = $waid[$key];



 

     $sql = "UPDATE wallet_address set isdeleted = 1, isrestore = 0, deletedate = '".$deletedate."', deleteby = '".$deleteby."' where waid = '".$thiswaid."'";



       $res = mysqli_query($conn, $sql);

   



        $sql = "INSERT INTO `wallet_address_history`(`waid`,`deletedate`,`deleteby`,`status`)

            VALUES ('$thiswaid','$deletedate','$deleteby','deleted')";

        $res = mysqli_query($conn, $sql);



        $sql =

            "INSERT INTO `user_activity`(`uid`,`remarks`,`activitydate`,`device`,`ip`,`status`)

                 VALUES ('$aid','$remarks','" .

            $deletedate .

            "','$device','$ip','delete')";

        $res = mysqli_query($conn, $sql); 

     }

    if($res)

    {



    $msg = "Wallet address successfully deleted ";

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

