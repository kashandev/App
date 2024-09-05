<?php
// include conn //
include_once('../conn/conn.php'); // this is used for include conn //
// end of include conn //
    // initializing variables//
    $sql                 = "";
    $res                 = "";
    $row                 = "";
    $data                = 0;
    // end of initializing variables//

if(isset($_POST['txid']) == ''){
    $_POST['txid'] = '';
    $txid = '';
}
if(isset($_POST['amount']) == ''){
    $_POST['amount'] = '';
    $amount = '';
}
if(isset($_POST['txid'])!=''){
    $txid = $_POST['txid'];
}
if(isset($_POST['amount'])!=''){
    $amount = $_POST['amount'];
}    
if($txid!='' && $amount!='')
{
$sql = "SELECT * from withdrawal as w WHERE w.txid = '".$txid."' AND w.withdrawal = '".$amount."' AND w.iscomplete = 1";

$res = mysqli_query($conn, $sql);
if(mysqli_num_rows($res))
{
$row = mysqli_fetch_array($res);
    $data = 1;
}else
{
    $data = 0;
}
}
echo $data;
?>