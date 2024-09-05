<?php

// Include session, IP, and connection files
include_once "../session/session.php"; 
include_once "../ip/ip.php"; 
include_once('../../conn/conn.php'); 

$data = [];
$msg = "Failed";

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

    // Fetch balance details
    $sql = "SELECT blid, SUM(bl.ibalance) as ibalance, bl.obalance 
            FROM balance as bl 
            WHERE bl.uid = ? AND bl.isapprove = 1 AND bl.isclose = 0 
            LIMIT 1";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('i', $uid);
    $stmt->execute();
    $result = $stmt->get_result();

    $blid = 0;
    $ibalance = $obalance = 0;

    if ($row = $result->fetch_assoc()) {
        $blid = $row['blid'];
        $ibalance = (float)$row['ibalance'];
        $obalance = (float)$row['obalance'];
    }

    $stmt->close();

    $thiswbalance = 0;

    // Approve deposits and update records
    foreach ($dpid as $thisdpid) {
        $thisdpid = (int)$thisdpid;

        $sql = "UPDATE deposite 
                SET isdeposit = 1, isapprove = 1, isnew = 0, approvedate = ?, approveby = ?, status = 'approved' 
                WHERE dpid = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param('ssi', $approvedate, $approveby, $thisdpid);
        $stmt->execute();
        $stmt->close();

        // Update wallet
        $sql = "UPDATE wallet 
                SET isapprove = 1, iswallet = 1, approvedate = ?, approveby = ?, status = 'approved' 
                WHERE dpid = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param('ssi', $approvedate, $approveby, $thisdpid);
        $stmt->execute();
        $stmt->close();

        // Update deposit wallet
        $sql = "UPDATE deposite_wallet 
                SET approvedate = ?, approveby = ?, status = 'approved' 
                WHERE dpid = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param('ssi', $approvedate, $approveby, $thisdpid);
        $stmt->execute();
        $stmt->close();

        // Update transaction
        $sql = "UPDATE transaction 
                SET istransaction = 1, status = 'approved' 
                WHERE dpid = ? AND istransaction = 0";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param('i', $thisdpid);
        $stmt->execute();
        $stmt->close();

        // Insert user activity
        $sql = "INSERT INTO user_activity (uid, remarks, activitydate, device, ip, status) 
                VALUES (?, ?, ?, ?, ?, 'approved')";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param('issss', $aid, $remarks, $approvedate, $device, $ip);
        $stmt->execute();
        $stmt->close();

        // Fetch wallet balance
        $sql = "SELECT wallet as wbalance 
                FROM wallet 
                WHERE dpid = ? AND isapprove = 1 AND iswallet = 1";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param('i', $thisdpid);
        $stmt->execute();
        $result = $stmt->get_result();

        while ($col = $result->fetch_assoc()) {
            $thiswbalance += (float)$col['wbalance'];
        }

        $stmt->close();
    }

    // Fetch total balance and update balance records
    $sql = "SELECT COUNT(ibalance) as tbalance, isclose 
            FROM balance 
            WHERE uid = ? AND isclose = 0 
            LIMIT 1";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('i', $uid);
    $stmt->execute();
    $result = $stmt->get_result();

    $tbalance = 0;
    $isclose = 0;

    if ($row = $result->fetch_assoc()) {
        $tbalance = $row['tbalance'];
        $isclose = $row['isclose'];

        $thisabalance = $ibalance + $thiswbalance;
        $thisrbalance = ($obalance != 0) ? ($thisabalance - $obalance) : $thisabalance;

        if ($tbalance == 0) {
            $sql = "INSERT INTO balance (uid, ibalance, rbalance, createdate) 
                    VALUES (?, ?, ?, ?, 1)";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param('idds', $uid, $thisabalance, $thisrbalance, $approvedate);
            $stmt->execute();
            $stmt->close();

            // Fetch the last inserted balance ID
            $blid = $conn->insert_id;
        } else {
            $sql = "UPDATE balance 
                    SET ibalance = ?, rbalance = ?, isapprove = 1
                    WHERE uid = ? AND isclose = 0 AND isapprove = 0";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param('ddi', $thisabalance, $thisrbalance, $uid);
            $stmt->execute();
            $stmt->close();
        }

        // Insert into balance history
        $sql = "INSERT INTO balance_history (uid, blid, type, balance, createdate, status) 
                VALUES (?, ?, 'deposit', ?, 'approved')";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param('iis', $uid, $blid, $thisrbalance,'approved');
        $stmt->execute();
        $stmt->close();

        $msg = "Deposit successfully approved";
    }

    $stmt->close();
}

// Output response
$data = [
    "msg" => $msg,
];
echo json_encode($data);
?>
