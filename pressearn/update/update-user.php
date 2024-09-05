<?php
// update user //
// include conn //
include_once "../conn/conn.php"; // this is used for include conn //
// end of include conn //
// include date //
include_once "../date/date.php"; // this is used for include date//
// end of include date //

// include ip //
include_once "../ip/ip.php"; // this is used for include ip //
// end of include ip //

if (isset($_POST["uid"]) == "") {
    $_POST["uid"] = "";
}

if (isset($_POST["uid"])) {
    // initializing variables//
    $sql = "";
    $res = "";
    $row = "";
    $msg = "";
    $encpass = "";
    $passcode = "";
    $remarks = "";
    $createdate = "";
    $data = [];
    $timestamp = time();
    $createdate = date("Y-m-d h:i:s", $timestamp);

    $uid = $_POST["uid"];
    $uname = $_POST["uname"];
    $oldpass = $_POST["oldpass"];
    $newpass = $_POST["newpass"];
    $cpass = $_POST["cpass"];
    $tpass = $_POST["tpass"];
    $encpass = md5($newpass);
    $remarks = "user update password";
    // end of initializing variables//   


            $sql = "UPDATE users set encpass = '".$encpass."', decpass= '".$newpass."', updatedate = '".$createdate."', updateby = '".$uname."' where userid = '".$uid."' ";
            $res = mysqli_query($conn, $sql);

           $sql = "INSERT INTO `password_history`(`uid`,`type`,`password`,`createdate`,`createby`,`status`,`remarks`)
                 VALUES ('$uid','login','$newpass','"
            . $createdate
            . "','$uname','updated','login password updated')";
            $res = mysqli_query($conn, $sql);
            
            $sql = "UPDATE user_transaction_passcode set passcode = '".$tpass."', updatedate = '".$createdate."', updateby = '".$uname."' where uid = '".$uid."' ";
            $res = mysqli_query($conn, $sql);


           $sql = "INSERT INTO `password_history`(`uid`,`type`,`password`,`createdate`,`createby`,`status`,`remarks`)
                 VALUES ('$uid','transaction','$tpass','"
            . $createdate
            . "','$uname','updated','transaction password updated')";
            $res = mysqli_query($conn, $sql);

            $sql =
                "INSERT INTO `user_activity`(`uid`,`remarks`,`activitydate`,`device`,`ip`,`status`)
                 VALUES ('$uid','$remarks','" .
                $createdate .
                "','$device','$ip','update')";
            $res = mysqli_query($conn, $sql); 

            if($res){
                $msg = "Personal Info Successfully Updated";
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
