<?php
// get method //
// initializing variables//
$tpmid = "";
$method = "";
$channel = "";
$sql = "";
$res = "";
$row = "";
$thistmpid = "";
$thismethod = "";
$thischannel = "";
$thismethoddiv = "";
$thischecked = "";
$data = [];
// end of initializing variables//


if (isset($_POST['waddress']) == '') {
    $_POST['waddress'] = '';
    $waddress = '';
}

if (isset($_POST['waddress']) != '') {
    $waddress = $_POST['waddress'];
}

if ($waddress != '') {
    // include conn //
    include_once '../conn/conn.php'; // this is used for include conn //
    // end of include conn //

        $sql = "SELECT * from topup_method order by tpmid asc ";
        $res = mysqli_query($conn, $sql);
        if (mysqli_num_rows($res)) {
            $row = mysqli_fetch_array($res);
            $tpmid = $row['tpmid'];
            $method = $row['tpmethod'];
            $thistmpid = $tpmid;
            $thismethod = $method;

            $data = ['tmpid' => $thistmpid,'method' => $thismethod];
        } else {
            $thistmpid = '';
            $thismethod = '';
            $data = [];
        } 
    echo json_encode($data);
    }


if ($waddress == '') {
    $sql = "SELECT * from topup_method order by tpmid asc ";

    $res = mysqli_query($conn, $sql);
    if (mysqli_num_rows($res)) {
        while ($row = mysqli_fetch_array($res)) {
            $tpmid = $row['tpmid'];
            $method = $row['tpmethod'];
            $channel = $row['tpchannel'];
            $thistmpid = $tpmid;
            $thismethod = $method;
            $thischannel = $channel;

            if ($tpmid == 1) {
                $thischecked = 'checked';
            } else {
                $thischecked = '';
            }
            $thismethoddiv .=
                '<div class="row">
     <div class="flexy">
    <label class="hash">' .
                $thismethod .
                '
    <input type="checkbox" class="tmpid" name="tmpid" ' .
                $thischecked .
                ' value=' .
                $thistmpid .
                ' onclick="onlyOne(this)">
    <span class="checkmark"></span>
    </label>
   </div>
 </div>';
        }
    } else {
        $thismethod = '';
        $thischannel = '';
        $thismethoddiv = '';
    }
    echo $thismethoddiv;
}
?>
