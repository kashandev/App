<?php
// get balance //
// include conn //
include_once('conn/conn.php'); // this is used for include conn //
date_default_timezone_set("Asia/Karachi"); // set timezone
// end of include conn //
// initializing variables//
$start_date = "";
$end_date = "";
$type = "";
$is_expire = 0;
$status = "";
$sql = "";
$res = "";
$row = "";

$start_date = date('Y-m-d');
$end_date = date('Y-m-d');
$type = "users";
$status = "enabled";
$is_expire = 0;
// end of initializing variables//
$sql = "INSERT INTO event SET startdate = '".$start_date."',enddate = '".$end_date."',type = '".$type."', isexpire = '".$is_expire."',status = '".$status."' ";
$res = mysqli_query($conn, $sql);
if($res) {
  echo "Insert Successfull";
}
else {
      echo mysqli_error();
      echo die();
}