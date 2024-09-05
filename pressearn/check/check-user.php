<?php
// check user //
// include conn //
include_once "../conn/conn.php"; // this is used for include conn //
// end of include conn //
if (isset($_POST["username"]) == "") {
    $_POST["username"] = "";
}
if (isset($_POST["username"])) {
    $username = $_POST["username"];
}
    // initializing variables//
    $sql = "";
    $res = "";
    $row = "";
    $msg = "";
    $data = false;
    // end of initializing variables//

    if($username!="")
    {
         $sql =
        "SELECT uname from users inner join roles on roles.roleid = users.roleid where users.uname = '" .
        $username."' and users.isdeleted = 0 and roles.role='user' limit 1";
    }
    $res = mysqli_query($conn, $sql);
    if ($row = mysqli_fetch_array($res)) {
      $data = false;
    } else {
      $data = true;
    }
   echo $data;
?>
