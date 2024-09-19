<?php
// set date //
 $date = '';
 $year = '';
 $printdate = '';
 $Login_Date = '';
 $Logout_Date = '';
 $startdate = '';
 $enddate = '';
 date_default_timezone_set('Asia/karachi');
 $date = date("d-m-Y");
 $year = date("Y");
 $printdate = date("d-m-Y h:i:s a");
 $Login_Date = date('Y-m-d h:i:s');
 $Logout_Date    = date('Y-m-d h:i:s');
 $startdate = date('Y-m-d');
 $enddate = date('Y-m-d', strtotime($startdate. '+2 days'));
?>