<?php
// Include connection and date files
include_once "../conn/conn.php";
include_once "../date/date.php";

// Variables initialization
$uid = isset($_GET["uid"]) ? $_GET["uid"] : "";
$tlvid = isset($_GET["tlvid"]) ? $_GET["tlvid"] : "";
$refcode = isset($_GET["refcode"]) ? $_GET["refcode"] : "";

$tmid = [];
$tuid = [];
$refc = [];
$retc = [];
$ulevel = "";
$thistbal = 0;

// Simulating data change for demo purposes
$lastChecked = isset($_GET['last_checked']) ? $_GET['last_checked'] : 0;
$newBalanceAvailable = false;
// Wait for new data (max wait time of 2 seconds)
$startTime = time();


    // Query to get the user's level based on refcode
    $sql = "SELECT level as ulevel FROM user_invitation_code WHERE invcode = '$refcode' AND status = 'new' LIMIT 1";
    $res = mysqli_query($conn, $sql);

    if (mysqli_num_rows($res)) {
        while ($row = mysqli_fetch_array($res)) {
            $ulevel = $row["ulevel"];
        }
    } else {
        $ulevel = "";
    }

    // Query to get team information based on refcode and level
    $sql = "SELECT teams.* FROM teams WHERE teams.refcode = '$refcode' AND levelfrom = '$ulevel'";
    $res = mysqli_query($conn, $sql);

    if (mysqli_num_rows($res)) {
        $x = 0;
        while ($row = mysqli_fetch_array($res)) {
            $tmid[$x] = $row["tmid"];
            $tuid[$x] = $row["uid"];
            $refc[$x] = $row["refcode"];
            $retc[$x] = $row["retcode"];
            $x++;
        }
        $newBalanceAvailable = true; // New balance data is available
    } else {
        $tmid = [];
        $tuid = [];
        $refc = [];
        $retc = [];
    }

    // Calculate total balance for each user in the team
    foreach ($tuid as $key => $thistuid) {
        $thisrefcode = $refc[$key];
        $thisretcode = $retc[$key];

        // Balance query based on user ID
        if ($tlvid == "") {
            $sql = "SELECT ROUND(SUM(bl.rbalance), 2) as tbal FROM balance as bl WHERE bl.uid = '$thistuid' AND bl.isapprove = 1 AND bl.isclose = 0 LIMIT 1";
            $res = mysqli_query($conn, $sql);

            if (mysqli_num_rows($res)) {
                while ($col = mysqli_fetch_array($res)) {
                    $tbal = $col["tbal"];
                    $thistbal += floatval($tbal);
                }
            } else {
                $thistbal = 0; // If no balance records found
            }
        }
    }

    while (!$newBalanceAvailable && (time() - $startTime) < 2) {

        return thistbal;

    // Wait before trying again to avoid CPU overload
    usleep(500000); // Sleep for 0.5 seconds
}


// Respond with the total balance or re-trigger polling if no new balance data after 30 seconds
if ($newBalanceAvailable) {
    echo json_encode(['total_balance' => $thistbal, 'last_checked' => time()]);
} else {
    echo json_encode(['total_balance' => 0, 'last_checked' => $lastChecked]);
}

$conn->close();
?>
