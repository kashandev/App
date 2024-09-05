<?php
// insert //
// include session //
include_once "../session/session.php"; // this is used for include session //
// end of include session //
// include ip //
include_once "../ip/ip.php"; // this is used for include ip //
// end of include ip //

// include date //
include_once "../date/date.php"; // this is used for include date//
// end of include date //

// include conn //
include_once "../conn/conn.php"; // this is used for include conn //
// end of include conn //

// include generate ref code //
include_once "../generate/generate-ref-code.php"; // this is used for include generate ref code //
// end of include generate ref code //
// variables //
$data = [];
$ilevel = [];
$ulevel = [];
$ualevel = [];
$tuser = [];
$level0 = "";
$level1 = "";
$level2 = "";
$level3 = "";
$msg = "";
$btn = "";
$timestamp = "";
$createdate = "";
$username = "";
$password = "";
$encpass = "";
$decpass = "";
$refcode = "";
$ccode = "";
$mobile = "";
$country = "";
$capcode = "";
$tpass = "";
$rid = "";
$uid = "";
$vcid = "";
$cpid = "";
$invcid = "";
$ulvid = "";
$ulvidf = "";
$ulvidt = "";
$invcode = "";
$thisinvcid = "";
$thisulvid = "";
$thisilevel = "";
$thisulevel = "";
$thisualevel = "";
$thistuser = "";
$x = 0;
$y = 0;
$z = 0;
$a = 0;
$imgname = "";
$imgguid = "";
$remarks = "";
$newcode = "";
$newlimit = "";
$User_ID_PK = "";
$User_Name = "";
$Dec_Password = "";
$Ref_Code = "";
$My_Ref_Code = "";
$Email = "";
$Encrypted_Password = "";
$Decrypted_Password = "";
$User_Email = "";
$User_Image_Name = "";
$User_Image_Guid = "";
$User_Inv_ID = "";
$Team_ID = "";
$check = false;
$Remarks = "";
$loginurl = "";
$loginid = "";
$sql = "";
$res = "";
$Login_Date = "";
$timestamp = time();
$createdate = date("Y-m-d h:i:s", $timestamp);
$Login_Date = $createdate;
// end of variables //
if (isset($_POST["username"])) {
    $rid = 4;
    $invcid = $_POST["invcid"];
    $username = $_POST["username"];
    $password = $_POST["password"];
    $refcode = $_POST["refcode"];
    $ccode = $_POST["ccode"];
    $ctitle = $_POST["ctitle"];
    $mobile = $_POST["mobile"];
    $country = $_POST["country"];
    $capcode = $_POST["capcode"];
    $tpass = $_POST["tpass"];
    $encpass = md5($password);
    $decpass = $password;
    $Email = $username;
    $Decrypted_Password = $decpass;
    $imgname = "default image";
    $imgguid = "grab.png";
    $remarks = "user signup";
    $newcode = $newrefcode;

    $sql = "INSERT INTO `users`( `roleid`, `uname`, `encpass`, `decpass`,`uimgname`,`uimgguid`,`ccode`,
      `ctitle`, `mobile`, `country`, `refcode`, `createdate`, `isdeleted`, `isblock`, `isnew`,`status`)
        VALUES ('$rid','$username','$encpass','$decpass','$imgname','$imgguid','$ccode','$ctitle','$mobile','$country','$refcode','$createdate',0,0,1,'new')";

    mysqli_query($conn, "SET CHARACTER SET utf8");

    if (mysqli_query($conn, $sql)) {
        $sql = "SELECT LAST_INSERT_ID()";
        $res = mysqli_query($conn, $sql);
        $row = mysqli_fetch_array($res);
        $uid = $row[0];
        $sql =
            "INSERT INTO `event`(`startdate`,`enddate`,`type`,`isexpire`,`status`)
        VALUES ('" .
            $startdate .
            "','" .
            $enddate .
            "','users',0,'enabled')";
        $res = mysqli_query($conn, $sql);

        $sql =
            "INSERT INTO `password_history`(`uid`,`type`,`password`,`createdate`,`createby`,`status`,`remarks`)
                 VALUES ('$uid','login','$decpass','" .
            $createdate .
            "','$username','created','login password created')";
        $res = mysqli_query($conn, $sql);

        $sql = "INSERT INTO `supporters`(`uid`, `sname`, `encpass`, `decpass`,`simgname`,`simgguid`,`ccode`, `ctitle`, `mobile`, `country`, `refcode`, `createdate`, `isdeleted`, `isnew`,`status`)
        VALUES ('$uid','$username','$encpass','$decpass','$imgname','$imgguid','$ccode','$ctitle','$mobile','$country','$refcode','$createdate',0,1,'new')";
        $res = mysqli_query($conn, $sql);

        $sql =
            "INSERT INTO `event`(`startdate`,`enddate`,`type`,`isexpire`,`status`)
        VALUES ('" .
            $startdate .
            "','" .
            $enddate .
            "','supporters',0,'enabled')";
        $res = mysqli_query($conn, $sql);

        $sql = "INSERT INTO `verification_code`(`uid`,`vfcode`,`createdate`)
            VALUES ('$uid','$capcode','$createdate')";
        $res = mysqli_query($conn, $sql);
        $sql = "SELECT LAST_INSERT_ID()";
        $res = mysqli_query($conn, $sql);
        $row = mysqli_fetch_array($res);
        $vcid = $row[0];
        $sql = "INSERT INTO `captcha_code`(`uid`,`cpcode`,`createdate`)
            VALUES ('$uid','$capcode','$createdate')";
        $res = mysqli_query($conn, $sql);
        $sql = "SELECT LAST_INSERT_ID()";
        $res = mysqli_query($conn, $sql);
        $row = mysqli_fetch_array($res);
        $cpid = $row[0];
        $sql = "INSERT INTO `user_verification`(`uid`,`cpid`,`vcid`,`verificationdate`,`isverified`,`status`)
            VALUES ('$uid','$cpid','$vcid','$createdate',1,'verified')";
        $res = mysqli_query($conn, $sql);

        $sql = "INSERT INTO `user_transaction_passcode`(`uid`,`passcode`,`createdate`)
            VALUES ('$uid','$tpass','$createdate')";
        $res = mysqli_query($conn, $sql);

        $sql =
            "INSERT INTO `password_history`(`uid`,`type`,`password`,`createdate`,`createby`,`status`,`remarks`)
                 VALUES ('$uid','transaction','$tpass','" .
            $createdate .
            "','$username','created','transaction password created')";
        $res = mysqli_query($conn, $sql);

        $sql =
            "INSERT INTO `user_invitation_code`(`uid`,`invcode`,`createdate`,`status`)
                 VALUES ('$uid','$newcode','" .
            $createdate .
            "','new')";
        $res = mysqli_query($conn, $sql);
        $sql = "SELECT LAST_INSERT_ID()";
        $res = mysqli_query($conn, $sql);
        $row = mysqli_fetch_array($res);
        $thisinvcid = $row[0];

        $sql =
            "SELECT count(invcode) as ilevel from user_invitation_code where status = 'new'";
        $res = mysqli_query($conn, $sql);
        if (mysqli_num_rows($res)) {
            while ($row = mysqli_fetch_array($res)) {
                $ilevel[$a] = $row["ilevel"];
                $a++;
            }

            for ($b = 0; $b < count($ilevel); $b++) {
                $thisilevel = $ilevel[$b];
                if ($thisilevel == 1) {
                    $sql =
                        "UPDATE user_invitation_code set level = 1 where invcid = '" .
                        $thisinvcid .
                        "' and status = 'new' limit 1";
                    $res = mysqli_query($conn, $sql);
                }
                if ($thisilevel == 2) {
                    $sql =
                        "UPDATE user_invitation_code set level = 2 where invcid = '" .
                        $thisinvcid .
                        "' and status = 'new' limit 1";
                    $res = mysqli_query($conn, $sql);
                }
                if ($thisilevel == 3) {
                    $sql =
                        "UPDATE user_invitation_code set level = 3 where invcid = '" .
                        $thisinvcid .
                        "' and status = 'new' limit 1";
                    $res = mysqli_query($conn, $sql);
                }
                if ($thisilevel > 3) {
                    $sql =
                        "UPDATE user_invitation_code set level = 1 where invcid = '" .
                        $thisinvcid .
                        "' and status = 'new' limit 1";
                    $res = mysqli_query($conn, $sql);
                }
            }
        }

        $sql = "INSERT INTO `user_attempt_invitation_code`(`uid`,`invcid`,`attemptdate`,`isused`,`status`)
            VALUES ('$uid','$invcid','$createdate',1,'attempted')";
        $res = mysqli_query($conn, $sql);
        $sql =
            "INSERT INTO `user_activity`(`uid`,`remarks`,`activitydate`,`device`,`ip`,`status`)
                 VALUES ('$uid','$remarks','" .
            $createdate .
            "','$device','$ip','signup')";
        $res = mysqli_query($conn, $sql);

        $sql =
            "INSERT INTO `user_invitation_code_activity`(`uid`,`invcid`,`activitydate`,`device`,`ip`,`status`)
                 VALUES ('$uid','$invcid','" .
            $createdate .
            "','$device','$ip','attempted')";
        $res = mysqli_query($conn, $sql);

        $sql =
            "INSERT INTO `user_signup`(`uid`,`remarks`,`signupdate`,`device`,`ip`,`status`)
                 VALUES ('$uid','$remarks','" .
            $createdate .
            "','$device','$ip','new')";
        $res = mysqli_query($conn, $sql);

        $sql = "SELECT level as ulevel from user_level";
        $res = mysqli_query($conn, $sql);

        if (mysqli_num_rows($res)) {
            while ($row = mysqli_fetch_array($res)) {
                $ulevel[$x] = $row["ulevel"];
                $x++;
            }
        } else {
            $ulevel[$x] = "";
        }

        $sql =
            "SELECT level as ualevel from user_invitation_code where invcode = '" .
            $refcode .
            "' and status = 'new' limit 1";
        $res = mysqli_query($conn, $sql);

        if (mysqli_num_rows($res)) {
            while ($col = mysqli_fetch_array($res)) {
                $ualevel[$y] = $col["ualevel"];
                $y++;
            }
        } else {
            $ualevel[$y] = "";
        }

        $sql =
            "SELECT count(userid) as tuser from users where refcode = '" .
            $refcode .
            "' and isdeleted = 0 limit 1";
        $res = mysqli_query($conn, $sql);

        if (mysqli_num_rows($res)) {
            while ($cols = mysqli_fetch_array($res)) {
                $tuser[$z] = $cols["tuser"];
                $z++;
            }
        } else {
            $tuser[$z] = "";
        }

        for ($i = 0; $i < count($ulevel); $i++) {
            $thisulevel = $ulevel[$i];
        }
        for ($j = 0; $j < count($ualevel); $j++) {
            $thisualevel = $ualevel[$j];
        }
        for ($k = 0; $k < count($tuser); $k++) {
            $thistuser = $tuser[$k];
        }

        if ($thisualevel == 1 && $thistuser >= 1) {
            $sql =
                "SELECT ulvid,level as level0  from user_level where level = 1";
            $res = mysqli_query($conn, $sql);
            if (mysqli_num_rows($res)) {
                while ($a = mysqli_fetch_array($res)) {
                    $ulvid = $a["ulvid"];
                    $level0 = $a["level0"];
                }
            }

            $sql =
                "SELECT level as level1 from user_invitation_code where level = 1 and status = 'new' limit 1";
            $res = mysqli_query($conn, $sql);
            if (mysqli_num_rows($res)) {
                while ($b = mysqli_fetch_array($res)) {
                    $level1 = $b["level1"];
                }
            }
            $sql =
                "INSERT INTO `user_assign_level`(`uid`,`ulvid`,`refid`,`retid`,`refcode`,`retcode`,`levelfrom`,`levelto`,`createdate`)
                 VALUES ('$uid','$ulvid','$invcid','$thisinvcid','$refcode','$newcode','$level0','$level1','" .
                $createdate .
                "')";

            $res = mysqli_query($conn, $sql);

            $sql =
                "INSERT INTO `teams`(`uid`,`refid`,`retid`,`ulvidf`,`ulvidt`,`refcode`,`retcode`,`levelfrom`,`levelto`,`createdate`,`status`,`remarks`)
          VALUES ('$uid','$invcid','$thisinvcid','$ulvid','$ulvid','$refcode','$newcode','$level0','$level1','" .
                $createdate .
                "','created','team created')";
            $res = mysqli_query($conn, $sql);
        }

        if ($thisualevel == 2 && $thistuser == 1) {
            $sql =
                "SELECT ulvid,level as level0  from user_level where level = 1";
            $res = mysqli_query($conn, $sql);
            if (mysqli_num_rows($res)) {
                while ($a = mysqli_fetch_array($res)) {
                    $ulvid = $a["ulvid"];
                    $level0 = $a["level0"];
                    $ulvidf = $ulvid;
                }
            }

            $sql =
                "SELECT ulvid,level as level2  from user_level where level = 2";
            $res = mysqli_query($conn, $sql);
            if (mysqli_num_rows($res)) {
                while ($a = mysqli_fetch_array($res)) {
                    $ulvid = $a["ulvid"];
                    $level2 = $a["level2"];
                    $ulvidt = $ulvid;
                }
            }

            $sql =
                "SELECT invcode  from user_invitation_code where level = 1 and status = 'new' limit 1";
            $res = mysqli_query($conn, $sql);
            if (mysqli_num_rows($res)) {
                while ($b = mysqli_fetch_array($res)) {
                    $invcode = $b["invcode"];
                }
            }

            $sql =
                "INSERT INTO `user_assign_level`(`uid`,`ulvid`,`refid`,`retid`,`refcode`,`retcode`,`levelfrom`,`levelto`,`createdate`)
                 VALUES ('$uid','$ulvid','$invcid','$thisinvcid','$invcode','$newcode','$level0','$level2','" .
                $createdate .
                "')";

            $res = mysqli_query($conn, $sql);

            $sql =
                "INSERT INTO `teams`(`uid`,`refid`,`retid`,`ulvidf`,`ulvidt`,`refcode`,`retcode`,`levelfrom`,`levelto`,`createdate`,`status`,`remarks`)
          VALUES ('$uid','$invcid','$thisinvcid','$ulvidf','$ulvidt','$invcode','$newcode','$level0','$level2','" .
                $createdate .
                "','created','team created')";
            $res = mysqli_query($conn, $sql);

            $sql =
                "SELECT ulvid,level as level1  from user_level where level = 1";
            $res = mysqli_query($conn, $sql);
            if (mysqli_num_rows($res)) {
                while ($a = mysqli_fetch_array($res)) {
                    $ulvid = $a["ulvid"];
                    $level1 = $a["level1"];
                    $ulvidf = $ulvid;
                }
            }

            $sql =
                "SELECT ulvid,level as level2  from user_level where level = 2";
            $res = mysqli_query($conn, $sql);
            if (mysqli_num_rows($res)) {
                while ($a = mysqli_fetch_array($res)) {
                    $ulvid = $a["ulvid"];
                    $level2 = $a["level2"];
                    $ulvidt = $ulvid;
                }
            }

            $sql =
                "INSERT INTO `user_assign_level`(`uid`,`ulvid`,`refid`,`retid`,`refcode`,`retcode`,`levelfrom`,`levelto`,`createdate`)
                 VALUES ('$uid','$ulvid','$invcid','$thisinvcid','$refcode','$newcode','$level2','$level1','" .
                $createdate .
                "')";

            $res = mysqli_query($conn, $sql);

            $sql =
                "INSERT INTO `teams`(`uid`,`refid`,`retid`,`ulvidf`,`ulvidt`,`refcode`,`retcode`,`levelfrom`,`levelto`,`createdate`,`status`,`remarks`)
          VALUES ('$uid','$invcid','$thisinvcid','$ulvidf','$ulvidt','$refcode','$newcode','$level2','$level1','" .
                $createdate .
                "','created','team created')";
            $res = mysqli_query($conn, $sql);
        }

        if ($thisualevel == 2 && $thistuser == 2) {
            $sql =
                "SELECT ulvid,level as level0  from user_level where level = 1";
            $res = mysqli_query($conn, $sql);
            if (mysqli_num_rows($res)) {
                while ($a = mysqli_fetch_array($res)) {
                    $ulvid = $a["ulvid"];
                    $level0 = $a["level0"];
                    $ulvidf = $ulvid;
                }
            }

            $sql =
                "SELECT ulvid,level as level3  from user_level where level = 3";
            $res = mysqli_query($conn, $sql);
            if (mysqli_num_rows($res)) {
                while ($a = mysqli_fetch_array($res)) {
                    $ulvid = $a["ulvid"];
                    $level3 = $a["level3"];
                    $ulvidt = $ulvid;
                }
            }

            $sql =
                "SELECT invcode  from user_invitation_code where level = 1 and status = 'new' limit 1";
            $res = mysqli_query($conn, $sql);
            if (mysqli_num_rows($res)) {
                while ($b = mysqli_fetch_array($res)) {
                    $invcode = $b["invcode"];
                }
            }
            $sql =
                "INSERT INTO `user_assign_level`(`uid`,`ulvid`,`refid`,`retid`,`refcode`,`retcode`,`levelfrom`,`levelto`,`createdate`)
                 VALUES ('$uid','$ulvid','$invcid','$thisinvcid','$invcode','$newcode','$level0','$level3','" .
                $createdate .
                "')";

            $res = mysqli_query($conn, $sql);

            $sql =
                "INSERT INTO `teams`(`uid`,`refid`,`retid`,`ulvidf`,`ulvidt`,`refcode`,`retcode`,`levelfrom`,`levelto`,`createdate`,`status`,`remarks`)
          VALUES ('$uid','$invcid','$thisinvcid','$ulvidf','$ulvidt','$invcode','$newcode','$level0','$level3','" .
                $createdate .
                "','created','team created')";
            $res = mysqli_query($conn, $sql);

    
          $sql =
                "SELECT ulvid,level as level1  from user_level where level = 1";
            $res = mysqli_query($conn, $sql);
            if (mysqli_num_rows($res)) {
                while ($a = mysqli_fetch_array($res)) {
                    $ulvid = $a["ulvid"];
                    $level1 = $a["level1"];
                    $ulvidf = $ulvid;
                }
            }

            $sql =
                "SELECT ulvid,level as level2  from user_level where level = 2";
            $res = mysqli_query($conn, $sql);
            if (mysqli_num_rows($res)) {
                while ($a = mysqli_fetch_array($res)) {
                    $ulvid = $a["ulvid"];
                    $level2 = $a["level2"];
                    $ulvidt = $ulvid;
                }
            }

            $sql =
                "INSERT INTO `user_assign_level`(`uid`,`ulvid`,`refid`,`retid`,`refcode`,`retcode`,`levelfrom`,`levelto`,`createdate`)
                 VALUES ('$uid','$ulvid','$invcid','$thisinvcid','$refcode','$newcode','$level2','$level1','" .
                $createdate .
                "')";

            $res = mysqli_query($conn, $sql);

            $sql =
                "INSERT INTO `teams`(`uid`,`refid`,`retid`,`ulvidf`,`ulvidt`,`refcode`,`retcode`,`levelfrom`,`levelto`,`createdate`,`status`,`remarks`)
          VALUES ('$uid','$invcid','$thisinvcid','$ulvidf','$ulvidt','$refcode','$newcode','$level2','$level1','" .
                $createdate .
                "','created','team created')";
            $res = mysqli_query($conn, $sql);

        }


        if ($thisualevel == 2 && $thistuser > 2) {
            $sql =
                "SELECT ulvid,level as level1  from user_level where level = 1";
            $res = mysqli_query($conn, $sql);
            if (mysqli_num_rows($res)) {
                while ($a = mysqli_fetch_array($res)) {
                    $ulvid = $a["ulvid"];
                    $level1 = $a["level1"];
                    $ulvidf = $ulvid;
                }
            }

            $sql =
                "SELECT ulvid,level as level2  from user_level where level = 2";
            $res = mysqli_query($conn, $sql);
            if (mysqli_num_rows($res)) {
                while ($a = mysqli_fetch_array($res)) {
                    $ulvid = $a["ulvid"];
                    $level2 = $a["level2"];
                    $ulvidt = $ulvid;
                }
            }

            $sql =
                "INSERT INTO `user_assign_level`(`uid`,`ulvid`,`refid`,`retid`,`refcode`,`retcode`,`levelfrom`,`levelto`,`createdate`)
                 VALUES ('$uid','$ulvid','$invcid','$thisinvcid','$refcode','$newcode','$level2','$level1','" .
                $createdate .
                "')";

            $res = mysqli_query($conn, $sql);

            $sql =
                "INSERT INTO `teams`(`uid`,`refid`,`retid`,`ulvidf`,`ulvidt`,`refcode`,`retcode`,`levelfrom`,`levelto`,`createdate`,`status`,`remarks`)
          VALUES ('$uid','$invcid','$thisinvcid','$ulvidf','$ulvidt','$refcode','$newcode','$level2','$level1','" .
                $createdate .
                "','created','team created')";
            $res = mysqli_query($conn, $sql);
        }


        if ($thisualevel == 3 && $thistuser == 1) {
            $sql =
                "SELECT ulvid,level as level2  from user_level where level = 2";
            $res = mysqli_query($conn, $sql);
            if (mysqli_num_rows($res)) {
                while ($a = mysqli_fetch_array($res)) {
                    $ulvid = $a["ulvid"];
                    $level2 = $a["level2"];
                }
            }

            $sql =
                "SELECT invcode  from user_invitation_code where level = 2 and status = 'new' limit 1";
            $res = mysqli_query($conn, $sql);
            if (mysqli_num_rows($res)) {
                while ($b = mysqli_fetch_array($res)) {
                    $invcode = $b["invcode"];
                }
            }

            $sql =
                "INSERT INTO `user_assign_level`(`uid`,`ulvid`,`refid`,`retid`,`refcode`,`retcode`,`levelfrom`,`levelto`,`createdate`)
                 VALUES ('$uid','$ulvid','$invcid','$thisinvcid','$invcode','$newcode','$level2','$level2','" .
                $createdate .
                "')";

            $res = mysqli_query($conn, $sql);

            $sql =
                "INSERT INTO `teams`(`uid`,`refid`,`retid`,`ulvidf`,`ulvidt`,`refcode`,`retcode`,`levelfrom`,`levelto`,`createdate`,`status`,`remarks`)
          VALUES ('$uid','$invcid','$thisinvcid','$ulvid','$ulvid','$invcode','$newcode','$level2','$level2','" .
                $createdate .
                "','created','team created')";
            $res = mysqli_query($conn, $sql);


           $sql =
                "SELECT invcode  from user_invitation_code where level = 3 and status = 'new' limit 1";
            $res = mysqli_query($conn, $sql);
            if (mysqli_num_rows($res)) {
                while ($b = mysqli_fetch_array($res)) {
                    $invcode = $b["invcode"];
                }
            }


            $sql =
                "SELECT ulvid,level as level1  from user_level where level = 1";
            $res = mysqli_query($conn, $sql);
            if (mysqli_num_rows($res)) {
                while ($a = mysqli_fetch_array($res)) {
                    $ulvid = $a["ulvid"];
                    $level1 = $a["level1"];
                    $ulvidf = $ulvid;
                }
            }

            $sql =
                "SELECT ulvid,level as level3  from user_level where level = 3";
            $res = mysqli_query($conn, $sql);
            if (mysqli_num_rows($res)) {
                while ($a = mysqli_fetch_array($res)) {
                    $ulvid = $a["ulvid"];
                    $level3 = $a["level3"];
                    $ulvidt = $ulvid;
                }
            }

            $sql =
                "INSERT INTO `user_assign_level`(`uid`,`ulvid`,`refid`,`retid`,`refcode`,`retcode`,`levelfrom`,`levelto`,`createdate`)
                 VALUES ('$uid','$ulvid','$invcid','$thisinvcid','$refcode','$newcode','$level3','$level1','" .
                $createdate .
                "')";

            $res = mysqli_query($conn, $sql);

            $sql =
                "INSERT INTO `teams`(`uid`,`refid`,`retid`,`ulvidf`,`ulvidt`,`refcode`,`retcode`,`levelfrom`,`levelto`,`createdate`,`status`,`remarks`)
          VALUES ('$uid','$invcid','$thisinvcid','$ulvidf','$ulvidt','$invcode','$newcode','$level3','$level1','" .
                $createdate .
                "','created','team created')";
            $res = mysqli_query($conn, $sql);
        }


        if ($thisualevel == 3 && $thistuser == 2) {
            $sql =
                "SELECT ulvid,level as level2  from user_level where level = 2";
            $res = mysqli_query($conn, $sql);
            if (mysqli_num_rows($res)) {
                while ($a = mysqli_fetch_array($res)) {
                    $ulvid = $a["ulvid"];
                    $level2 = $a["level2"];
                    $ulvidf = $ulvid;
                }
            }

            $sql =
                "SELECT ulvid,level as level3  from user_level where level = 3";
            $res = mysqli_query($conn, $sql);
            if (mysqli_num_rows($res)) {
                while ($a = mysqli_fetch_array($res)) {
                    $ulvid = $a["ulvid"];
                    $level3 = $a["level3"];
                    $ulvidt = $ulvid;
                }
            }

            $sql =
                "SELECT invcode  from user_invitation_code where level = 2 and status = 'new' limit 1";
            $res = mysqli_query($conn, $sql);
            if (mysqli_num_rows($res)) {
                while ($b = mysqli_fetch_array($res)) {
                    $invcode = $b["invcode"];
                }
            }

            $sql =
                "INSERT INTO `user_assign_level`(`uid`,`ulvid`,`refid`,`retid`,`refcode`,`retcode`,`levelfrom`,`levelto`,`createdate`)
                 VALUES ('$uid','$ulvid','$invcid','$thisinvcid','$invcode','$newcode','$level2','$level3','" .
                $createdate .
                "')";

            $res = mysqli_query($conn, $sql);

            $sql =
                "INSERT INTO `teams`(`uid`,`refid`,`retid`,`ulvidf`,`ulvidt`,`refcode`,`retcode`,`levelfrom`,`levelto`,`createdate`,`status`,`remarks`)
          VALUES ('$uid','$invcid','$thisinvcid','$ulvidf','$ulvidt','$invcode','$newcode','$level2','$level3','" .
                $createdate .
                "','created','team created')";
            $res = mysqli_query($conn, $sql);

     
            $sql =
                "SELECT invcode  from user_invitation_code where level = 3 and status = 'new' limit 1";
            $res = mysqli_query($conn, $sql);
            if (mysqli_num_rows($res)) {
                while ($b = mysqli_fetch_array($res)) {
                    $invcode = $b["invcode"];
                }
            }   

            $sql =
                "SELECT ulvid,level as level2  from user_level where level = 2";
            $res = mysqli_query($conn, $sql);
            if (mysqli_num_rows($res)) {
                while ($a = mysqli_fetch_array($res)) {
                    $ulvid = $a["ulvid"];
                    $level2 = $a["level2"];
                    $ulvidf = $ulvid;
                }
            }

            $sql =
                "SELECT ulvid,level as level3  from user_level where level = 3";
            $res = mysqli_query($conn, $sql);
            if (mysqli_num_rows($res)) {
                while ($a = mysqli_fetch_array($res)) {
                    $ulvid = $a["ulvid"];
                    $level3 = $a["level3"];
                    $ulvidt = $ulvid;
                }
            }

            $sql =
                "INSERT INTO `user_assign_level`(`uid`,`ulvid`,`refid`,`retid`,`refcode`,`retcode`,`levelfrom`,`levelto`,`createdate`)
                 VALUES ('$uid','$ulvid','$invcid','$thisinvcid','$refcode','$newcode','$level3','$level2','" .
                $createdate .
                "')";

            $res = mysqli_query($conn, $sql);

            $sql =
                "INSERT INTO `teams`(`uid`,`refid`,`retid`,`ulvidf`,`ulvidt`,`refcode`,`retcode`,`levelfrom`,`levelto`,`createdate`,`status`,`remarks`)
          VALUES ('$uid','$invcid','$thisinvcid','$ulvidf','$ulvidt','$invcode','$newcode','$level3','$level2','" .
                $createdate .
                "','created','team created')";
            $res = mysqli_query($conn, $sql);

        }

        if ($thisualevel == 3 && $thistuser == 3) {
            $sql =
                "SELECT ulvid,level as level3  from user_level where level = 3";
            $res = mysqli_query($conn, $sql);
            if (mysqli_num_rows($res)) {
                while ($a = mysqli_fetch_array($res)) {
                    $ulvid = $a["ulvid"];
                    $level3 = $a["level3"];
                }
            }
         
         $sql =
                "SELECT invcode  from user_invitation_code where level = 3 and status = 'new' limit 1";
            $res = mysqli_query($conn, $sql);
            if (mysqli_num_rows($res)) {
                while ($b = mysqli_fetch_array($res)) {
                    $invcode = $b["invcode"];
                }
            }   

            $sql =
                "INSERT INTO `user_assign_level`(`uid`,`ulvid`,`refid`,`retid`,`refcode`,`retcode`,`levelfrom`,`levelto`,`createdate`)
                 VALUES ('$uid','$ulvid','$invcid','$thisinvcid','$refcode','$newcode','$level3','$level3','" .
                $createdate .
                "')";

            $res = mysqli_query($conn, $sql);

            $sql =
                "INSERT INTO `teams`(`uid`,`refid`,`retid`,`ulvidf`,`ulvidt`,`refcode`,`retcode`,`levelfrom`,`levelto`,`createdate`,`status`,`remarks`)
          VALUES ('$uid','$invcid','$thisinvcid','$ulvid','$ulvid','$invcode','$newcode','$level3','$level3','" .
                $createdate .
                "','created','team created')";
            $res = mysqli_query($conn, $sql);
        }


        if ($thisualevel == 3 && $thistuser > 3) {
            $sql =
                "SELECT ulvid,level as level1  from user_level where level = 1";
            $res = mysqli_query($conn, $sql);
            if (mysqli_num_rows($res)) {
                while ($a = mysqli_fetch_array($res)) {
                    $ulvid = $a["ulvid"];
                    $level3 = $a["level1"];
                    $ulvidf = $ulvid;
                }
            }

            $sql =
                "SELECT ulvid,level as level3  from user_level where level = 3";
            $res = mysqli_query($conn, $sql);
            if (mysqli_num_rows($res)) {
                while ($a = mysqli_fetch_array($res)) {
                    $ulvid = $a["ulvid"];
                    $level3 = $a["level3"];
                    $ulvidt = $ulvid;
                }
            }

            $sql =
                "INSERT INTO `user_assign_level`(`uid`,`ulvid`,`refid`,`retid`,`refcode`,`retcode`,`levelfrom`,`levelto`,`createdate`)
                 VALUES ('$uid','$ulvid','$invcid','$thisinvcid','$refcode','$newcode','$level3','$level1','" .
                $createdate .
                "')";

            $res = mysqli_query($conn, $sql);

            $sql =
                "INSERT INTO `teams`(`uid`,`refid`,`retid`,`ulvidf`,`ulvidt`,`refcode`,`retcode`,`levelfrom`,`levelto`,`createdate`,`status`,`remarks`)
          VALUES ('$uid','$invcid','$thisinvcid','$ulvid','$ulvid','$refcode','$newcode','$level3','$level1','" .
                $createdate .
                "','created','team created')";
            $res = mysqli_query($conn, $sql);
        }
        
        // check row //
        $sql = "SELECT * from users where uname = '" . $Email . "' ";
        $res = mysqli_query($conn, $sql);
        if ($row = mysqli_fetch_array($res)) {
            $check = true;
        } else {
            $check = false;
        }
        // end of check row //

        // check true result //
        if ($check == true) {
            // login query //
            $sql =
                "SELECT users.*,roles.*,(SELECT user_invitation_code.invcid from user_invitation_code WHERE user_invitation_code.uid=users.userid LIMIT 1) as uinvid,(SELECT user_invitation_code.invcode from user_invitation_code WHERE user_invitation_code.uid=users.userid LIMIT 1) as uinvcode,(SELECT teams.tmid from teams WHERE teams.uid=users.userid LIMIT 1) as tmid from users inner join roles on roles.roleid = users.roleid WHERE users.uname = '" .
                $Email .
                "' and users.isdeleted =0 and roles.role in('user')";
            // end of login query //

            // get result //
            $res = mysqli_query($conn, $sql);
            // loop for get rows //
            foreach ($res as $key => $row) {
                // set rows in variables from db
                $User_ID_PK = $row["userid"];
                $User_Role_ID = $row["roleid"];
                $User_Role = $row["role"];
                $User_Name = $row["uname"];
                $Ref_Code = $row["refcode"];
                $My_Ref_Code = $row["uinvcode"];
                $User_Email = $row["email"];
                $Encrypted_Password = $row["encpass"];
                $Dec_Password = $row["decpass"];
                $User_Image_Name = $row["uimgname"];
                $User_Image_Guid = $row["uimgguid"];
                $User_Inv_ID = $row["uinvid"];
                $Team_ID = $row["tmid"];
                $Remarks = $User_Role . " " . "login";
                $loginid = "loginid=" . base64_encode($User_ID_PK) . "";
                $loginurl =
                    "my-account.php?" . "" . $loginid . "&pageid=account";
                //end of set rows in variables from db

                // check variables //
                if (
                    $Email == $User_Name &&
                    md5($Decrypted_Password) == $Encrypted_Password
                ) {
                    $_SESSION["u_id_pk"] = $User_ID_PK;
                    $_SESSION["u_name"] = $User_Name;
                    $_SESSION["ref_code"] = $Ref_Code;
                    $_SESSION["my_ref_code"] = $My_Ref_Code;
                    $_SESSION["u_email"] = $User_Email;
                    $_SESSION["u_image_name"] = $User_Image_Name;
                    $_SESSION["u_image_guid"] = $User_Image_Guid;
                    $_SESSION["u_role_id"] = $User_Role_ID;
                    $_SESSION["u_role"] = $User_Role;
                    $_SESSION["u_inv_id"] = $User_Inv_ID;
                    $_SESSION["u_tm_id"] = $Team_ID;
                    $_SESSION["login_id"] = $loginid;

                    $_SESSION["welcome_user_message"] = "Welcome";

                    $sql =
                        "INSERT INTO `user_login`(`uid`,`remarks`,`loginid`,`logindate`,`device`,`ip`,`islogin`,`status`)
                 VALUES ('$User_ID_PK','$Remarks','$loginid','" .
                        $Login_Date .
                        "','$device','$ip',1,'login')";
                    $res = mysqli_query($conn, $sql);

                    $sql =
                        "INSERT INTO `user_activity`(`uid`,`remarks`,`activitydate`,`device`,`ip`,`status`)
                 VALUES ('$User_ID_PK','$Remarks','" .
                        $Login_Date .
                        "','$device','$ip','login')";
                    $res = mysqli_query($conn, $sql);
                }
                // end of check variables //
            }
            // end of loop for get rows//
        }
        // end of check true result//

        $msg = "You have successfully registered";
    } else {
        $msg = "Failed";
        $loginurl = "";
    }
    $data = [
        "msg" => $msg,
        "loginurl" => $loginurl,
    ];

    echo json_encode($data);
}
