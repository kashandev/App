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

if (isset($_POST["wtid"])) {
    $wtid = $_POST["wtid"];
    $uid = $_POST["uid"];
    $aid = $_POST["aid"];
    $approveby = $_POST["uname"];
    $remarks = "approve withdrawal";

    // Fetch balance details
    $sql = "SELECT blid, ibalance, SUM(obalance) as obalance 
            FROM balance 
            WHERE uid = ? AND isapprove = 1 AND isclose = 0 
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

    // Approve withdrawals and update records
    foreach ($wtid as $thiswtid) {
        $thiswtid = (int)$thiswtid;

        $sql = "UPDATE withdrawal 
                SET iswithdrawal = 1, isapprove = 1, isnew = 0, approvedate = ?, approveby = ?, status = 'paid' 
                WHERE wtid = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param('ssi', $approvedate, $approveby, $thiswtid);
        $stmt->execute();
        $stmt->close();

        // Update wallet
        $sql = "UPDATE wallet 
                SET isapprove = 1, iswallet = 1, approvedate = ?, approveby = ?, status = 'paid' 
                WHERE wtid = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param('ssi', $approvedate, $approveby, $thiswtid);
        $stmt->execute();
        $stmt->close();

        // Update withdrawal wallet
        $sql = "UPDATE withdrawal_wallet 
                SET approvedate = ?, approveby = ?, status = 'paid' 
                WHERE wtid = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param('ssi', $approvedate, $approveby, $thiswtid);
        $stmt->execute();
        $stmt->close();

        // Update transaction
        $sql = "UPDATE transaction 
                SET istransaction = 1, status = 'paid' 
                WHERE wtid = ? AND istransaction = 0";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param('i', $thiswtid);
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
                WHERE wtid = ? AND isapprove = 1 AND iswallet = 1";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param('i', $thiswtid);
        $stmt->execute();
        $result = $stmt->get_result();

        while ($col = $result->fetch_assoc()) {
            $thiswbalance += (float)$col['wbalance'];
        }

        $stmt->close();
    }

    // Update balance records
    $thistibalance = $ibalance;
    $thistobalance = $obalance + $thiswbalance;
    $thisrbalance = $thistibalance - $thistobalance;

    if ($thisrbalance != 0) {
        $sql = "UPDATE balance 
                SET obalance = ?, rbalance = ? 
                WHERE uid = ? AND isclose = 0 AND isapprove = 1";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param('ddi', $thistobalance, $thisrbalance, $uid);
        $stmt->execute();
        $stmt->close();

        // Insert into balance history
        $sql = "INSERT INTO balance_history (uid, blid, balance, createdate, status) 
                VALUES (?, ?, 'withdrawal', ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param('iis', $uid, $blid, $thisrbalance, $approvedate,'approved');
        $stmt->execute();
        $stmt->close();
    } else {
        $sql = "UPDATE balance 
                SET isclose = 1, obalance = ?, rbalance = ? 
                WHERE uid = ? AND isclose = 0 AND isapprove = 1";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param('ddi', $thistobalance, $thisrbalance, $uid);
        $stmt->execute();
        $stmt->close();

        // Insert into balance history
        $sql = "INSERT INTO balance_history (uid, blid, balance, createdate, status) 
                VALUES (?, ?, 'withdrawal', ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param('iis', $uid, $blid, $thisrbalance, $approvedate,'approved');
        $stmt->execute();
        $stmt->close();
    }

    if ($stmt) {
        $msg = "Withdrawal successfully approved";
    }
}

// Output response
$data = [
    "msg" => $msg,
];
echo json_encode($data);
?>
