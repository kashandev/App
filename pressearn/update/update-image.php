<?php
// update image //
// include session //
include_once "../session/session.php"; // this is used for include session //
// end of include session //s
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
    $uid = "";
    $uname = "";
    $img = "";
    $createdate = "";
    $data = [];
    $timestamp = time();
    $createdate = date("Y-m-d h:i:s", $timestamp);

    $uid = $_POST["uid"];
    $uname = $_POST["uname"];
    $img = $_POST["img"];
    $remarks = "user update profile image";
    // end of initializing variables//   
          $sql = "UPDATE users set uimgname = 'profile image', uimgguid = '".$img."', updatedate = '".$createdate."', updateby = '".$uname."' where userid = '".$uid."' ";

           $res = mysqli_query($conn, $sql);

            $sql =
                "INSERT INTO `user_activity`(`uid`,`remarks`,`activitydate`,`device`,`ip`,`status`)
                 VALUES ('$uid','$remarks','" .
                $createdate .
                "','$device','$ip','update')";
            $res = mysqli_query($conn, $sql); 

            if($res){
             $msg = "Profile Picture Successfully Updated";
             $_SESSION["u_image_guid"] = $img;
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
