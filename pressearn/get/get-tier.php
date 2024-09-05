<div class="row">
<?php
// get tier //
// include conn //
include_once "../conn/conn.php"; // this is used for include conn //
// end of include conn //

// include ip //
include_once "../ip/ip.php"; // this is used for include ip //
// end of include ip //

// initializing variables//
$uid = "";
$tlvid = "";
$utlvid = "";
$ustlvid = [];
$title = "";
$level = "";
$tno = "";
$lrange = "";
$com = "";
$pcom = "";
$islock = "";
$status = "";
$thistlvid = "";
$thisutlvid = "";
$thistitle = "";
$thislevel = "";
$thistno = "";
$thislrange = "";
$thiscom = "";
$thispcom = "";
$thisislock = "";
$thisstatus = "";
$thistier = "";
$sql = "";
$utlsql = "";
$isql = "";
$tiersql = "";
$utiersql = "";
$updatesql1 = "";
$updatesql2 = "";
$updatesql3 = "";
$updatesql4 = "";
$rangesql1 = "";
$rangesql2 = "";
$rangesql3 = "";
$rangesql4 = "";
$tierres = "";
$utierres = "";
$updateres1 = "";
$updateres2 = "";
$updateres3 = "";
$updateres4 = "";
$utlres = "";
$rangeres1 = "";
$rangeres2 = "";
$rangeres3 = "";
$rangeres4 = "";
$avbalance = "";
$thisavbalance = 0;
$x = 0;
$res = "";
$ires = "";
$row = "";
$col = "";
$z = "";
$remarks = "";
$thisbtn = "";
$class = "";
$createdate = "";
$timestamp = time();
$createdate = date("Y-m-d h:i:s", $timestamp);
// end of initializing variables//

if (isset($_POST["uid"]) == "") {
    $_POST["uid"] = "";
    $uid = "";
}

if (isset($_POST["uid"])) {
    $uid = $_POST["uid"];
}

$sql = "SELECT * from user_tier_level WHERE uid = '" . $uid . "'";
$res = mysqli_query($conn, $sql);
if ($row = mysqli_num_rows($res) == 0) {
    $tiersql = "SELECT * from tier_level";
    $tierres = mysqli_query($conn, $tiersql);

    if (mysqli_num_rows($tierres)) {
        foreach ($tierres as $key => $row) {
            $tlvid = $row["tlvid"];
            $title = $row["title"];
            $level = $row["level"];
            $tno = $row["tno"];
            $lrange = $row["lrange"];
            $com = $row["com"];
            $pcom = $row["pcom"];
            $islock = $row["islock"];
            $status = $row["status"];
            $thistitle = $title;
            $thislevel = $level;
            $thistno = $tno;
            $thislrange = $lrange;
            $thiscom = $com;
            $thispcom = $pcom;
            $thisislock = $islock;
            $remarks = "user tier level";
            $isql = "INSERT INTO `user_tier_level`( `uid`,`tlvid`,`title`,`level`,`tno`,`lrange`,`com`,`pcom`,`createdate`,`islock`,`status`)
         VALUES ('$uid','$tlvid','$thistitle','$thislevel','$thistno','$thislrange','$thiscom','$thispcom','$createdate',1,'lock')";

            $ires = mysqli_query($conn, $isql);

            $sql =
                "INSERT INTO `user_activity`(`uid`,`remarks`,`activitydate`,`device`,`ip`,`status`)
                 VALUES ('$uid','$remarks','" .
                $createdate .
                "','$device','$ip','created')";
            $res = mysqli_query($conn, $sql);
        }
    }
}
$utlsql = "SELECT * from user_tier_level WHERE uid = '" . $uid . "'";
$utlres = mysqli_query($conn, $utlsql);
if (mysqli_num_rows($utlres)) {
    foreach ($utlres as $key => $z) {
        $ustlvid[$x] = $z["utlvid"];
        $x++;
    }
}
foreach ($ustlvid as $key => $thisutlvid) {
    $thisutlvid = $ustlvid[$key];

    $rangesql1 =
        "SELECT bl.rbalance as avbalance from balance as bl where isclose = 0 and rbalance >=100  and isclose = 0 AND uid = '" .
        $uid .
        "' order by bl.blid desc ";

    $rangeres1 = mysqli_query($conn, $rangesql1);
    if (mysqli_num_rows($rangeres1)) {
        foreach ($rangeres1 as $key => $row) {
            $avbalance = $row["avbalance"];
            $thisavbalance = (int) $avbalance;

            if ($thisavbalance >= 100) {
                $updatesql1 =
                    "UPDATE user_tier_level set islock = 0, unlockdate = now(), status = 'unlock' where uid = '" .
                    $uid .
                    "' and utlvid = '" .
                    $thisutlvid .
                    "' and islock = 1 and level = 'LV1' limit 1";
                $updateres1 = mysqli_query($conn, $updatesql1);
            }
        }
    } else {
        $updatesql1 =
            "UPDATE user_tier_level set islock = 1, status = 'lock' where islock = 0 and uid = '" .
            $uid .
            "' and utlvid = '" .
            $thisutlvid .
            "' and level = 'LV1' limit 1";
        $updateres1 = mysqli_query($conn, $updatesql1);
    }
    // end of tier 1 balance range query //

    // tier 2 balance range query //
    $rangesql2 =
        "SELECT bl.rbalance as avbalance from balance as bl where isclose = 0 and rbalance >=500 and isclose = 0 AND uid = '" .
        $uid .
        "' order by bl.blid desc";

    $rangeres2 = mysqli_query($conn, $rangesql2);
    if (mysqli_num_rows($rangeres2)) {
        foreach ($rangeres2 as $key => $row) {
            $avbalance = $row["avbalance"];
            $thisavbalance = (int) $avbalance;

            if ($thisavbalance >= 500) {
                $updatesql2 =
                    "UPDATE user_tier_level set islock = 0, unlockdate = now(), status = 'unlock' where uid = '" .
                    $uid .
                    "' and utlvid = '" .
                    $thisutlvid .
                    "' and islock = 1 and level = 'LV2' limit 1";
                $updateres2 = mysqli_query($conn, $updatesql2);
            }
        }
    } else {
        $updatesql2 =
            "UPDATE user_tier_level set islock = 1, status = 'lock' where islock = 0 and uid = '" .
            $uid .
            "' and utlvid = '" .
            $thisutlvid .
            "' and level = 'LV2' limit 1";
        $updateres2 = mysqli_query($conn, $updatesql2);
    }
    // end of tier 2 balance range query //

    // tier 3 balance range query //
    $rangesql3 =
        "SELECT bl.rbalance as avbalance from balance as bl where isclose = 0 and rbalance >=1000 and isclose = 0 AND uid = '" .
        $uid .
        "' order by bl.blid desc";
    $rangeres3 = mysqli_query($conn, $rangesql3);
    if (mysqli_num_rows($rangeres3)) {
        foreach ($rangeres3 as $key => $row) {
            $avbalance = $row["avbalance"];
            $thisavbalance = (int) $avbalance;

            if ($thisavbalance >= 1000) {
                $updatesql3 =
                    "UPDATE user_tier_level set islock = 0, unlockdate = now(), status = 'unlock' where uid = '" .
                    $uid .
                    "' and utlvid = '" .
                    $thisutlvid .
                    "' and islock = 1 and level = 'LV3' limit 1";
                $updateres3 = mysqli_query($conn, $updatesql3);
            }
        }
    } else {
        $updatesql3 =
            "UPDATE user_tier_level set islock = 1, status = 'lock' where islock = 0 and uid = '" .
            $uid .
            "' and utlvid = '" .
            $thisutlvid .
            "' and level = 'LV3' limit 1";
        $updateres3 = mysqli_query($conn, $updatesql3);
    }
    // end of tier 3 balance range query //

    // tier 4 balance range query //
    $rangesql4 =
        "SELECT bl.rbalance as avbalance from balance as bl where isclose = 0 and rbalance >=2000 and isclose = 0 AND uid = '" .
        $uid .
        "' order by bl.blid desc";
    $rangeres4 = mysqli_query($conn, $rangesql4);
    if (mysqli_num_rows($rangeres4)) {
        foreach ($rangeres4 as $key => $row) {
            $avbalance = $row["avbalance"];
            $thisavbalance = (int) $avbalance;

            if ($thisavbalance >= 2000) {
                $updatesql4 =
                    "UPDATE user_tier_level set islock = 0, unlockdate = now(), status = 'unlock' where uid = '" .
                    $uid .
                    "' and utlvid = '" .
                    $thisutlvid .
                    "' and islock = 1 and level = 'LV4' limit 1";
                $updateres4 = mysqli_query($conn, $updatesql4);
            }
        }
    } else {
        $updatesql4 =
            "UPDATE user_tier_level set islock = 1, status = 'lock' where islock = 0 and uid = '" .
            $uid .
            "' and utlvid = '" .
            $thisutlvid .
            "' and level = 'LV4' limit 1";
        $updateres4 = mysqli_query($conn, $updatesql4);
    }
}
// end of tier 4 balance range query //

$tiersql = "SELECT * from user_tier_level WHERE uid = '" . $uid . "'";
$tierres = mysqli_query($conn, $tiersql);
if (mysqli_num_rows($tierres)) { ?>
<?php foreach ($tierres as $key => $row) {
    $utlvid = $row["utlvid"];
    $title = $row["title"];
    $level = $row["level"];
    $tno = $row["tno"];
    $lrange = $row["lrange"];
    $com = $row["com"];
    $pcom = $row["pcom"];
    $islock = $row["islock"];
    $status = $row["status"];
    $thistitle = $title;
    $thislevel = $level;
    $thistno = $tno;
    $thislrange = $lrange;
    $thiscom = $com;
    $thispcom = $pcom;
    $thisislock = $islock;
    if ($thisislock == 1) {
        $class = "btn-lock";
    } else {
        $class = "btn-unlock";
    }
    $thisislock == 1
        ? ($thisstatus =
            '<a class="' .
            $class .
            '" data-id="' .
            $utlvid .
            '" data-title="' .
            $title .
            '" data-range="' .
            $thislrange .
            '" data-tno="' .
            $thistno .
            '" data-com="' .
            $thiscom .
            '" data-p-com="' .
            $thispcom .
            '"><i class="fas fa-lock"></i> ' .
            ucfirst($status) .
            "</a>")
        : ($thisstatus =
            '<a class="' .
            $class .
            '" data-id="' .
            $utlvid .
            '" data-title="' .
            $title .
            '" data-range="' .
            $thislrange .
            '" data-tno="' .
            $thistno .
            '" data-com="' .
            $thiscom .
            '" data-p-com="' .
            $thispcom .
            '"><i class="fas fa-unlock"></i> ' .
            ucfirst($status) .
            "</a>");
    $thistier .=
        '
   <div class="col-md-3">
        <div class="maintrr">
        <h2>' .
        $thistitle .
        '
        <div class="mainicon">
        ' .
        $thisstatus .
        '
        </div></h2>
            <div class="tr">
              <small>' .
        $thislevel .
        "-Ord(" .
        $thistno .
        ") <br> (" .
        $thislrange .
        ')</small>
            </div>
            
            <div class="trcom">
              <h6>' .
        $thiscom .
        ' Commission</h6>
               <p>(' .
        $thispcom .
        ')</p>
            </div>     
        </div>
        </div>
   ';
} ?>
<?php } else {$thistier = "There is no tier/level available!";}
echo $thistier;
?>
</div>
