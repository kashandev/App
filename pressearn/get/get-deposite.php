<?php
// get deposit //
// include conn //
include_once '../conn/conn.php'; // this is used for include conn //
// end of include conn //
// initializing variables//
$dpid = "";
$sql = "";
$res = "";
$row = "";
$thisdpid = "";
$data = [];
// end of initializing variables//

if (isset($_POST['txid']) == '') {
    $_POST['txid'] = '';
    $txid = '';
}

if (isset($_POST['amount']) == '') {
    $_POST['amount'] = '';
    $amount = '';
}

if (isset($_POST['txid']) != '') {
    $txid = $_POST['txid'];
}

if (isset($_POST['amount']) != '') {
    $amount = $_POST['amount'];
}

if ($txid != '' && $amount != '') {
    $sql = "SELECT d.dpid,d.deposit from deposite as d WHERE d.txid = '" . $txid . "' AND d.deposit = '" . $amount . "' AND d.isapprove = 1";

    $res = mysqli_query($conn, $sql);
    if (mysqli_num_rows($res)) {
        $row = mysqli_fetch_array($res);
        $dpid = $row['dpid'];
        $thisdpid = $dpid;

        $data = ['dpid' => $thisdpid];
    } else {
        $thisdpid = '';
        $data = ['dpid' => $thisdpid];
    }
}
echo json_encode($data);
?>
