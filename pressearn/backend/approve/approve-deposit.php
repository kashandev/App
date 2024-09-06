<?php

// Include session, IP, and connection files
include_once "../session/session.php"; 
include_once "../ip/ip.php"; 
include_once "../function/function.php"; 
include_once('../../conn/conn.php'); 

$data = [];
$msg = "";
$thisdpid = '';
$thisbluid = '';
$thisid = '';
$blid = 0;
$wbalance = 0;
$thiswbalance = 0;
$total_balance = 0;


// Initialize variables
$timestamp = time();
$approvedate = date("Y-m-d H:i:s", $timestamp);
$date = date("d-m-Y");

if (isset($_POST["dpid"])) {
    $dpid = $_POST["dpid"];
    $uid = $_POST["uid"];
    $aid = $_POST["aid"];
    $approveby = $_POST["uname"];
    $remarks = "approve deposit";
    $thisid = implode("','",$dpid);

    // Approve deposits and update records
    foreach ($dpid as $thisdpid) {
        $thisdpid = (int)$thisdpid;

        $sql = "UPDATE deposite 
                SET isdeposit = 1, isapprove = 1, isnew = 0, approvedate = '$approvedate', approveby = '$approveby', status = 'approved' 
                WHERE dpid = '$thisdpid'";
        $res = mysqli_query($conn,$sql);

        // Update wallet
        $sql = "UPDATE wallet 
                SET isapprove = 1, iswallet = 1, approvedate = '$approvedate', approveby = '$approveby', status = 'approved' 
                WHERE dpid = '$thisdpid'";
        $res = mysqli_query($conn,$sql);

        // Update deposit wallet
        $sql = "UPDATE deposite_wallet 
                SET approvedate = '$approvedate', approveby = '$approveby', status = 'approved' 
                WHERE dpid = '$thisdpid'";
        $res = mysqli_query($conn,$sql);

        // Update transaction
        $sql = "UPDATE transaction 
                SET istransaction = 1, status = 'approved' 
                WHERE dpid = '".$thisdpid."' AND istransaction = 0";
         $res = mysqli_query($conn,$sql);

        // Insert user activity
        $sql = "INSERT INTO user_activity (uid, remarks, activitydate, device, ip, status) 
                VALUES ('$aid', ' $remarks', '$approvedate', '$device', '$ip', 'approved')";
        $res = mysqli_query($conn,$sql);

}

        // Fetch wallet balance
        $sql = "SELECT txid, SUM(wl.wallet) AS wbalance
                FROM wallet AS wl
                WHERE wl.dpid IN('$thisid') AND wl.uid = '$uid' AND wl.iswallet = 1 AND wl.isapprove = 1
                LIMIT 1";
        $res = mysqli_query($conn,$sql);

        if(mysqli_num_rows($res) > 0) {

         $row = mysqli_fetch_assoc($res);
             $thisbluid = $row['txid'];   
             $wbalance = (float)$row['wbalance'];
             $thiswbalance = ($wbalance);
       }
        else {
        $msg = "Sorry no deposit available";   
        $wbalance = 0;
      }


       if($wbalance > 0) {
        // check if exists balance
        $sql = "SELECT COUNT(*) as total_balance 
        FROM balance AS bl
        WHERE bl.bluid = '$thisbluid' AND bl.uid = '$uid' AND bl.isapprove = 1 AND bl.isclose = 0
        LIMIT 1";
        $res = mysqli_query($conn,$sql);
        $total_balance = mysqli_fetch_assoc($res);

        if ($total_balance['total_balance'] == 0) {
            $sql = "INSERT INTO balance (uid, bluid, ibalance, rbalance, createdate) 
                    VALUES ('$uid', '$thisbluid', '$thiswbalance', '$thiswbalance', '$approvedate')";
            $res = mysqli_query($conn,$sql);

        //     Fetch the last inserted balance ID
            $blid = mysqli_insert_id($conn);
        } else {

        // Fetch wallet balance
        $sql = "SELECT bl.blid,bl.ibalance AS tbalance
                FROM balance AS bl
                WHERE bl.bluid = '$thisbluid' AND bl.uid = '$uid' AND bl.isapprove = 1 AND bl.isclose = 0
                LIMIT 1";
        $res = mysqli_query($conn,$sql);

        if(mysqli_num_rows($res) > 0) {
            $row = mysqli_fetch_assoc($res);
             $blid = $row['blid'];
             $tbalance = (float)$row['tbalance'];
             $thiswbalance = ($tbalance + $thiswbalance);
              
             echo $blid;
            // $sql = "UPDATE balance 
            //         SET ibalance = '$thiswbalance', rbalance = '$thiswbalance'
            //         WHERE blid = '$blid' AND uid = '$uid' AND isclose = 0 AND isapprove = 1";
            // $res = mysqli_query($conn,$sql);

           // Insert into balance history
          $sql = "INSERT INTO balance_history (uid, blid, type, balance, createdate, status) 
          VALUES ('$uid','$blid', 'deposit', '$thiswbalance', 'approved')";
          $res = mysqli_query($conn,$sql);
         } 
       }    
     }

    // if($res) {
    //     $msg = "Deposit successfully approved";
    // }
    // else {
    //     $msg = "Deposit approved was failed";
    // }


// // Output response
// $data = [
//     "msg" => $msg,
// ];
// echo json_encode($data);
}
?>
