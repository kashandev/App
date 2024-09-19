<?php

// include get session //

include_once "../session/session.php"; // this is used for include get session//

// end of include get session //

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

$approvedate = "";

$date = "";

$wtid = "";

$uid = "";

$uname = "";

$approveby = "";

$sql = "";

$res = "";

$thiswtid = '';

$thiswlid = '';

$row = 0;

$wbalance = 0;

$ibalance = 0;

$tbalance = 0;

$isclose = 0;

$thisibalance = 0;

$thiswbalance = 0;

$thisabalance = 0;

$timestamp = time();

$approvedate = date("Y-m-d h:i:s", $timestamp);

$date = date("d-m-Y");

// end of variables //

if (isset($_POST["wtid"])) {

    $wtid = $_POST["wtid"];

    $aid = $_POST["aid"];

    $approveby = $_POST["uname"];

    $remarks = "disapprove withdrawal";

 foreach ($wtid as $key => $thiswtid) {

       $thiswtid = $wtid[$key];



    $sql = "UPDATE withdrawal set isapprove = 0, isnew = 0, disapprovedate = '".$approvedate."', disapproveby = '".$approveby."'  where wtid = '".$thiswtid."'";

    $res = mysqli_query($conn, $sql);

     $sql =

            "INSERT INTO `user_activity`(`uid`,`remarks`,`activitydate`,`device`,`ip`,`status`)

                 VALUES ('$aid','$remarks','" .

            $approvedate .

            "','$device','$ip','approve')";

        $res = mysqli_query($conn, $sql); 

     }



    if($res)

    {



    $msg = "Withdrawal successfully disapproved ";

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

