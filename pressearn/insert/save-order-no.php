<?php

// save order no //

// include date //

include_once "../date/date.php"; // this is used for include date//

// end of include date //

// include ip //

include_once "../ip/ip.php"; // this is used for include ip //

// end of include ip //

// include conn //

include_once "../conn/conn.php"; // this is used for include conn //

// end of include conn //

$timestamp = "";

$createdate = "";

$tlvid = "";

$uid = "";

$noid = "";

$sql = "";

$res = "";

$trno = "";

$thistno = "";

$thisrno = "";

$thistrno = "";

$tno = 0;

$count = 0;

$data = [];

$timestamp = time();

$createdate = date("Y-m-d h:i:s", $timestamp);

// end of variables //

if (isset($_POST["tlvid"])) {

    $tlvid = $_POST["tlvid"];

    $uid = $_POST["uid"];

    $tno = $_POST["tno"];

    $remarks = "user no of order";

    $sql =

        "SELECT count(noid) as noid FROM no_of_orders WHERE uid = '" .

        $uid .

        "' AND tlvid = '" .

        $tlvid .

        "' AND iscomplete = 0 order by noid desc";



    $res = mysqli_query($conn, $sql);

    if (mysqli_num_rows($res)) {

        if ($row = mysqli_fetch_array($res)) {

            $count = $row["noid"];



            if ($count == 0) {

                $thistno = $tno;

                $thistrno = $tno;

                $sql = "INSERT INTO `no_of_orders`( `uid`,`tlvid`,`tno`,`rno`,`createdate`,`iscomplete`)

         VALUES ('$uid','$tlvid','$thistno','$thistrno','$createdate',0)";

                $res = mysqli_query($conn, $sql);

                $sql = "SELECT LAST_INSERT_ID()";

                $res = mysqli_query($conn, $sql);

                $row = mysqli_fetch_array($res);

                $noid = $row[0];



                $sql =

                    "INSERT INTO `user_activity`(`uid`,`remarks`,`activitydate`,`device`,`ip`,`status`)

                 VALUES ('$uid','$remarks','" .

                    $createdate .

                    "','$device','$ip','created')";

                $res = mysqli_query($conn, $sql);



                $data = [

                    "noid" => $noid,

                ];

            } else {

                $sql =

                    "SELECT noid,rno as rno FROM no_of_orders WHERE uid = '" .

                    $uid .

                    "' AND tlvid = '" .

                    $tlvid .

                    "' AND iscomplete = 0 order by noid desc";

                $res = mysqli_query($conn, $sql);



                if (mysqli_num_rows($res)) {

                    if ($row = mysqli_fetch_array($res)) {

                        $noid = $row["noid"];

                        $rno = $row["rno"];

                        $thistno = $tno;

                        $thisrno = (int) $rno;

                        $sql =

                            "UPDATE `no_of_orders` set tno = '" .

                            $thistno .

                            "' , rno = '" .

                            $thisrno .

                            "' WHERE uid = '" .

                            $uid .

                            "' AND tlvid = '" .

                            $tlvid .

                            "' AND noid = '" .

                            $noid .

                            "' and iscomplete = 0";

                        $res = mysqli_query($conn, $sql);



                        $data = [

                            "noid" => $noid,

                        ];

                    }

                }

            }

        }

    }

    echo json_encode($data);

}

?>

