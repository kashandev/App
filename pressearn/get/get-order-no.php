<?php

// get order no //

// include conn //

include_once "../conn/conn.php"; // this is used for include conn //

// end of include conn //

$tlvid = "";

$uid = "";

$sql = "";

$res = "";

$todaytno = "";

$todayrno = "";

$thistodaytno = 0;

$thistodayrno = 0;

$data = [];

// end of variables //

if (isset($_POST["noid"])) {

    $noid = $_POST["noid"];

    $tlvid = $_POST["tlvid"];

    $uid = $_POST["uid"];




    $sql =

        "SELECT tno as todaytno, rno as todayrno FROM no_of_orders WHERE uid = '" .

        $uid .

        "' AND tlvid = '" .

        $tlvid .

        "' AND noid = '" .

        $noid .

        "'  AND iscomplete = 0 order by noid desc ";

    $res = mysqli_query($conn, $sql);



    if (mysqli_num_rows($res)) {

        while ($row = mysqli_fetch_array($res)) {

            $todaytno = $row["todaytno"];

            $todayrno = $row["todayrno"];

            $thistodaytno = (int)($todaytno);

            $thistodayrno = (int)($todayrno);

        }

        $data = [

            "tno" => $thistodaytno,

            "rno" => $thistodayrno,

        ];

    } else {

        $data = [

            "tno" => "",

            "rno" => "",

        ];

    }

    echo json_encode($data);

}

?>

