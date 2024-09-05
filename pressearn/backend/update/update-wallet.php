<?php

// approve withdrawal //

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

$updatedate = "";

$date = "";

$dpid = "";

$uid = "";

$updateby = "";

$name = "";

$waddress = "";

$wadd = "";

$company = "";

$sql = "";

$res = "";

$thiswaid = '';

$status = '';

$row = 0;

$col = 0;

$timestamp = time();

$updatedate = date("Y-m-d h:i:s", $timestamp);

$date = date("d-m-Y");

// end of variables //

if (isset($_POST["waid"])) {

    $waid = $_POST["waid"];

    $cid = $_POST["cid"];

    $uid = $_POST["userid"];

    $updateby = $_POST["username"];

    $name = $_POST["name"];

    $wadd = $_POST["wadd"];

    $company = $_POST["company"];

    $isactive = $_POST["isactive"];

    $remarks = "update wallet address";


    $isactive == 1 ? $status = 'active' : 'inactive';
 

     $sql = "UPDATE company set company = '".$company."', isedit = 1, updatedate = '".$updatedate."', updateby = '".$updateby."' where cid = '".$cid."'";



     $res = mysqli_query($conn, $sql);

 

     $sql = "UPDATE wallet_address set name = '".$name."', waddress = '".$wadd."', isactive = '".$isactive."', updatedate = '".$updatedate."', updateby = '".$updateby."', status = '".$status."' where waid = '".$waid."'";



     $res = mysqli_query($conn, $sql);

     

     $sql = "INSERT INTO `wallet_address_history`(`waid`,`updatedate`,`updateby`,`status`)

            VALUES ('$waid','$updatedate','$updateby','updated')";

     $res = mysqli_query($conn, $sql);



     $sql =

            "INSERT INTO `user_activity`(`uid`,`remarks`,`activitydate`,`device`,`ip`,`status`)

                 VALUES ('$uid','$remarks','" .

            $updatedate .

            "','$device','$ip','$status')";

     $res = mysqli_query($conn, $sql); 



    if($res)

    {

    $msg = "Wallet address successfully updated ";

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

