<?php
// count user //
// include conn //
include_once "../../conn/conn.php"; // this is used for include conn //
// end of include conn //
// initializing variables//
$count = 0;
$sql = "";
$res = "";
$row = "";
$msg = "";
$data = 0;
// end of initializing variables//
   
    $sql =
        "SELECT * from users inner join roles on roles.roleid = users.roleid where users.isdeleted = 0 and users.isnew = 1 and roles.role='user' limit 1";
    $res = mysqli_query($conn, $sql);
    $row = mysqli_num_rows($res);
    if ($row > 0) {
       $data = 1;
    } else {
       $data = 0;
    }
    echo $data;
?>
