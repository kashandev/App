<?php
// get user //
// include conn //
include_once('../../conn/conn.php'); // this is used for include conn //
// end of include conn //

// include date //
include_once "../date/date.php"; // this is used for include date//
// end of include date //

// initializing variables//
$sql = "";
$res = "";
$row = "";
$enddate = "";
$nowdate = "";
$data = [];
// end of initializing variables//
 $sql = "SELECT * from event WHERE event.isexpire = 0 LIMIT 1";
 $res = mysqli_query($conn, $sql);

if ($row = mysqli_fetch_array($res)) {
	$nowdate = $startdate;
	$enddate = $row['enddate'];
   $data = array('startdate'=>$startdate,'enddate'=>$enddate);
} else {
   $data = array('startdate'=>$startdate,'enddate'=>$enddate);
}
echo json_encode($data);

