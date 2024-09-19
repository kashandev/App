<?php

// Include session and IP address
include_once "../session/session.php"; 
include_once "../ip/ip.php"; 

// Include database connection
include_once('../../conn/conn.php'); 

$data = [];
$msg = "";
$timestamp = time();
$rejectdate = date("Y-m-d h:i:s", $timestamp);

if (isset($_POST["dpid"])) {
    $dpidArray = $_POST["dpid"];
    $aid = $_POST["aid"];
    $rejectby = $_POST["uname"];
    $remarks = "reject deposit";
    $isSuccessful = false; // Flag to track overall success of queries



    foreach ($dpidArray as $thisdpid) {


        // Update deposit record
        $sql = "UPDATE deposite 
                SET isdeposit = 0, isapprove = 0, isreject = 1, 
                    rejectdate = '$rejectdate', rejectby = '$rejectby', status='rejected' 
                WHERE dpid = '$thisdpid'";


          echo $sql;

        // $res = mysqli_query($conn, $sql);        

       // Update balance record
        $sql = "UPDATE balance 
        SET isapprove = 0
        WHERE dpid = '$thisdpid'";
        $res = mysqli_query($conn, $sql);

        // Insert into balance history
        $sql = "INSERT INTO `balance_history`(`uid`, `blid`, `balance`, `createdate`, `status`)
                VALUES ('$uid', '$blid', 'deposit', '$rejectdate', 'rejected')";
        echo $sql;
        // $res = mysqli_query($conn, $sql);  


        // Update wallet record
        $sql = "UPDATE wallet 
                SET isapprove = 0, iswallet = 0, isreject = 1, 
                    rejectdate = '$rejectdate', rejectby = '$rejectby', status = 'rejected' 
                WHERE dpid = '$thisdpid'";
        // $res = mysqli_query($conn, $sql);  

        // Update deposit_wallet record
        $sql = "UPDATE deposite_wallet 
                SET rejectdate = '$rejectdate', rejectby = '$rejectby', status = 'rejected' 
                WHERE dpid = '$thisdpid'";
       echo $sql;

        // $res = mysqli_query($conn, $sql);  

        // Update transaction record
        $sql = "UPDATE transaction 
                SET istransaction = 0, status = 'rejected' 
                WHERE dpid = '$thisdpid' AND istransaction = 1";
        // $res = mysqli_query($conn, $sql);  
        echo $sql;


        // Insert into user activity
        $sql = "INSERT INTO `user_activity`(`uid`, `remarks`, `activitydate`, `device`, `ip`, `status`)
                VALUES ('$aid', '$remarks', '$rejectdate', '$device', '$ip', 'rejected')";
        echo $sql;
        // $res = mysqli_query($conn, $sql);  
    }

    // if($res){
    //     $isSuccessful = true;
    // }
    // else {
    //     $isSuccessful = false;
    // }

    // // Set message based on the overall success of the operations
    // $msg = $isSuccessful == true ? "Deposit successfully rejected" : "Failed";

    // $data = ["msg" => $msg];
    // echo json_encode($data);
}
?>
