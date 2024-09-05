<?php
// view team deposit
// include connection
include_once "../conn/conn.php";

// Variables
$message = '';
$perPage = 10;
$page = isset($_POST["page"]) ? (int)$_POST["page"] : 1;
$type = $_POST["type"] ?? "";
$search = $_POST["search"] ?? "";
$uid = $_POST["uid"] ?? "";
$refcode = $_POST["refcode"] ?? "";

// Fetch user level based on refcode
$ulevel = "";
$sql = "SELECT level as ulevel FROM user_invitation_code WHERE invcode = '$refcode' AND status = 'new' LIMIT 1";
$res = mysqli_query($conn, $sql);
if ($row = mysqli_fetch_assoc($res)) {
    $ulevel = $row["ulevel"];
}

// Fetch team UIDs based on refcode and user level
$tuid = [];
$sql = "SELECT uid FROM teams WHERE refcode = '$refcode' AND levelfrom = '$ulevel' GROUP BY uid";
$res = mysqli_query($conn, $sql);
while ($row = mysqli_fetch_assoc($res)) {
    $tuid[] = $row["uid"];
}

// Initialize pagination
$totalRecords = 0;
$totalPages = 1;
$startFrom = max(0, ($page - 1) * $perPage); // Ensure startFrom is never negative
$paginationHtml = "";
$paginationCtrls = "";


// Display header
echo '<div class="table-responsive">';
echo '<h2 style="text-align: center;"><strong>Deposit</strong></h2>';
echo '<table class="table table-striped table-bordered all-table" id="table">';
echo '<thead><tr><th>User Name</th><th>Ref Code</th><th>Deposit Date</th><th>Deposit</th><th>Status</th></tr></thead><tbody>';

// Loop through each UID and fetch deposits
foreach ($tuid as $thistuid) {
    $all_qry = "SELECT users.uname, deposite.*, 
               (SELECT levelto FROM user_assign_level WHERE uid = users.userid LIMIT 1) AS downlinelv 
               FROM deposite 
               INNER JOIN users ON users.userid = deposite.uid 
               WHERE deposite.isdeposit = 1 AND deposite.isapprove = 1 AND deposite.uid = '$thistuid' 
               ORDER BY deposite.dpid DESC LIMIT $startFrom, $perPage";

    $res = mysqli_query($conn, $all_qry);
    $totalRecords += mysqli_num_rows($res);
    $totalPages = max(1, ceil($totalRecords / $perPage));

    if ($totalRecords > 0) {
        $message = '';
        while ($row = mysqli_fetch_assoc($res)) {
            $status = $row["isapprove"] == 1 ? '<strong style="color:#089000!important;">Approved</strong>' : '<strong style="color:#4285F4!important;">Pending</strong>';
            $status = $row["isreject"] == 1 ? '<strong style="color:#4285F4!important;">Rejected</strong>' : '<strong style="color:#089000!important;">Approved</strong>';
            $deposit = '$' . $row["deposit"];
            $date = date_create($row["depositdate"]);
            $formattedDate = date_format($date, "d-m-Y");
            switch ($row["downlinelv"]) {
                case 1:
                    $downlineLevel = "Downline lv 1";
                    break;
                case 2:
                    $downlineLevel = "Downline lv 2";
                    break;
                case 3:
                    $downlineLevel = "Downline lv 3";
                    break;
                default:
                    $downlineLevel = "";
            }
            

            echo "<tr>
                <td>{$row['uname']}</td>
                <td>{$row['refcode']}</td>
                <td>$formattedDate</td>
                <td>$deposit</td>
                <td>$status</td>
            </tr>";
        }
    } else {
        $message = 'There is no team deposit found';
    }
}

echo '<tr><td colspan="5" class="text-center">'.$message.'</td></tr>';

echo '</tbody></table>';

// Pagination Controls
if ($totalPages > 1) {
    if ($page > 1) {
        $paginationCtrls .= '<a data-page="' . ($page - 1) . '" class="btn btn-default btn-page">Pre</a> &nbsp;';
    }
    for ($i = 1; $i <= $totalPages; $i++) {
        $class = $i == $page ? 'style="background-color: #110863 !important;color: #fffd;"' : 'style="background-color: #fff;border-color: #ccc;"';
        $paginationCtrls .= '<a data-page="' . $i . '" class="btn btn-default btn-page" ' . $class . '>' . $i . '</a> &nbsp; ';
    }
    if ($page < $totalPages) {
        $paginationCtrls .= '<a data-page="' . ($page + 1) . '" class="btn btn-default btn-next">Next</a>';
    }
}

echo '<div id="pagination" class="pagination">' . $paginationCtrls . '</div>';
echo '</div>';
?>
