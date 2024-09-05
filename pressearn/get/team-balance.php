<?php
// Include connection and date files
include_once "../conn/conn.php";
include_once "../date/date.php";

header('Content-Type: text/event-stream');
header('Cache-Control: no-cache');

// Variables initialization
$uid = isset($_GET["uid"]) ? $_GET["uid"] : "";
$tlvid = isset($_GET["tlvid"]) ? $_GET["tlvid"] : "";
$refcode = isset($_GET["refcode"]) ? $_GET["refcode"] : "";

$ulevel = "";
$thistbal = 0;

// Query to get the user's level based on refcode using prepared statement
$sql = "SELECT level as ulevel FROM user_invitation_code WHERE invcode = ? AND status = 'new' LIMIT 1";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $refcode);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $ulevel = $row["ulevel"];
}

// Query to get team information based on refcode and level with balance calculation
$sql = "SELECT t.tmid, t.uid, t.refcode, t.retcode, 
               COALESCE(SUM(b.rbalance), 0) AS total_balance
        FROM teams t
        LEFT JOIN balance b ON t.uid = b.uid AND b.isapprove = 1 AND b.isclose = 0
        WHERE t.refcode = ? AND t.levelfrom = ?
        GROUP BY t.tmid, t.uid, t.refcode, t.retcode";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ss", $refcode, $ulevel);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $thistbal += floatval($row['total_balance']);
    }
}

// Respond with the total balance or indicate no new balance data
echo "data: " . json_encode(['total_balance' => $thistbal, 'last_checked' => time()]) . "\n\n";
flush();

$conn->close();
?>
