<?php

// save deposit //

// include date //

include_once "../date/date.php"; // this is used for include date//

// end of include date //

// include ip //

include_once "../ip/ip.php"; // this is used for include ip //

// end of include ip //

// include conn //

include_once "../../conn/conn.php"; // this is used for include conn //

// end of include conn //

$data = [];

$msg = "";

$btn = "";

$timestamp = "";

$createdate = "";

$uid = "";

$cid = "";

$waid = "";

$createby = "";

$name = "";

$waddress = "";

$wadd = "";

$company = "";

$so = "";

$sql = "";

$res = "";

$sortorder = 0;

$isactive = "";

$checkaddress=  false;

$timestamp = time();

$createdate = date("Y-m-d h:i:s", $timestamp);

// end of variables //

if (isset($_POST["userid"])) {

    $uid = $_POST["userid"];

    $createby = $_POST["username"];

    $name = $_POST["name"];

    $wadd = $_POST["wadd"];

    $company = $_POST["company"];

    $isactive = $_POST["isactive"];

    $remarks = "add wallet address";

      $sql = "SELECT wa.* from wallet_address as wa where wa.isdeleted = 0 and wa.waddress = '".$wadd."' limit 1 ";

        $res = mysqli_query($conn, $sql);

        if ($row = mysqli_fetch_array($res)) {

         $checkaddress = true;

        }else{

          $checkaddress = false;  

        }

        if($checkaddress == true){

            $msg = "This wallet address already exists! ";

        $data = [

        "msg" => $msg,

        ];

        }else{



     $sql = "INSERT INTO `company`(`company`,`createdate`,`createby`,`isdeleted`,`status`)

          VALUES ('$company','$createdate','$createby',0,'created')";  



    if (mysqli_query($conn, $sql)) {



        $sql = "SELECT LAST_INSERT_ID()";

        $res = mysqli_query($conn, $sql);

        $row = mysqli_fetch_array($res);

        $cid = $row[0];



        $sql = "SELECT count(wa.sortorder)+1 as so from wallet_address as wa where wa.isdeleted = 0 limit 1 ";

        $res = mysqli_query($conn, $sql);

        while ($row = mysqli_fetch_array($res)) {

         $so = $row['so'];

         $sortorder = (int)($so);

        }



        $sql = "INSERT INTO `wallet_address`(`cid`,`name`,`waddress`,`sortorder`,`createdate`,`createby`)

          VALUES ('$cid','$name','$wadd','$sortorder','$createdate','$createby');";



        $res = mysqli_query($conn, $sql);

        $sql = "SELECT LAST_INSERT_ID()";

        $res = mysqli_query($conn, $sql);

        $row = mysqli_fetch_array($res);

        $waid = $row[0];



        $sql = "INSERT INTO `wallet_address_history`(`waid`,`createdate`,`createby`,`status`)

            VALUES ('$waid','$createdate','$createby','created')";

        $res = mysqli_query($conn, $sql);



        $sql =

            "INSERT INTO `user_activity`(`uid`,`remarks`,`activitydate`,`device`,`ip`,`status`)

                 VALUES ('$uid','$remarks','" .

            $createdate .

            "','$device','$ip','created')";

        $res = mysqli_query($conn, $sql);



        $msg = "Wallet address successfully added ";

      }

    else {

        $msg = "Failed";

    }

    $data = [

        "msg" => $msg,

    ];

}

 echo json_encode($data);

}

?>

