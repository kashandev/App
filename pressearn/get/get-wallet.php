<?php

// get wallet //

// include conn //

include_once('../conn/conn.php'); // this is used for include conn //

// end of include conn //



    // initializing variables//

$waid                = "";

$waddress            = "";

$sql                 = "";

$res                 = "";

$row                 = "";

$thiswaddress        = "";

$data[]              = "";

    // end of initializing variables//



$sql = "SELECT * from wallet_address where isdeleted = 0 and wallet_address.isactive = 1 order by sortorder desc limit 1 ";

$res = mysqli_query($conn, $sql);

if (mysqli_num_rows($res)) {

    while ($row = mysqli_fetch_array($res)) {

        $waid = $row['waid'];

        $waddress = $row['waddress'];

        $data = array('waid' => $waid, 'waddress' => $waddress);

    }

} else {

    $waid = '';

    $waddress = '';

    $data = array('waid' => $waid, 'waddress' => $waddress);

}

echo json_encode($data);

