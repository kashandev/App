<?php
// update user //
// include conn //
include_once "../../conn/conn.php"; // this is used for include conn //
// end of include conn //
$sql = '';
$res  ='';
     $sql = "UPDATE users set isnew = 0 where isnew = 1 ";
     $res = mysqli_query($conn, $sql);

     $sql = "UPDATE supporters set isnew = 0 where isnew = 1 ";
     $res = mysqli_query($conn, $sql);
 
     $sql = "UPDATE event set isexpire = 1,status = 'disabled' where isexpire = 0 ";
     $res = mysqli_query($conn, $sql); 
?>
