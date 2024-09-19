<?php

// delete user //

// include session //

include_once "../session/session.php"; // this is used for include session//

// end of include session //

// include ip //

include_once "../ip/ip.php"; // this is used for include ip //

// end of include ip //

// include conn //

include_once('../conn/config.php'); // this is used for include conn //

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

$deleteby = "";

$sql = "";

$res = "";

$thisuid = '';

$timestamp = time();

$deletedate = date("Y-m-d h:i:s", $timestamp);

$date = date("d-m-Y");

// end of variables //



if (isset($_POST["uid"])) {

    $uid = $_POST["uid"];

    $aid = $_POST["aid"];

    $deleteby = $_POST["uname"];

    $remarks = "delete user";

     foreach ($uid as $key => $thisuid) {

     $thisuid = $uid[$key];



 

     $sql = "UPDATE users set isdeleted = 1, isblock = 0, isrestore = 0,  deletedate = '".$deletedate."', deleteby = '".$deleteby."' where userid = '".$thisuid."'";



       $res = mysqli_query($conn, $sql);

   



        $sql = "INSERT INTO `delete_history`(`uid`,`createdate`,`createby`,`device`,`ip`,`status`)

            VALUES ('$thisuid','$deletedate','$deleteby','$device','$ip','deleted')";

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



    $msg = "User successfully deleted ";

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

