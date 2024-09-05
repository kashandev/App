<?php

// team com //

// include conn //

include_once "../conn/conn.php"; // this is used for include conn //

// end of include conn //

// include date //

include_once "../date/date.php"; // this is used for include date//

// end of include date //



// variables //



$uid = "";

$tlvid = "";

$refcode = "";

$sql = "";

$res = "";

$tmid = [];

$tuid = [];

$refid = [];

$retid = [];

$ulvidf = [];

$ulvidt = [];

$refc = [];

$retc = [];

$levelf = [];

$levelt = [];

$data = [];

$output = [];

$ulevel = "";

$tcom = "";

$tcoma = "";

$tcomb = "";

$pcom = "";

$pcoma = "";

$pcomb = "";

$ultvid = "";

$tlid = "";

$x = 0;

$y = 0;

$thistmid = "";

$thistuid = "";

$thisrefid = "";

$thisretid = "";

$thisulvidf = "";

$thisulvidt = "";

$thisrefcode = "";

$thisretcode = "";

$thislevelf = "";

$thislevelt = "";

$thispcoma = 0;

$thispcomb = 0;

$thispcomc = 0;

$thistcoma = 0;

$thistcomb = 0;

$thistcomc = 0;

$thiscoma = 0;

$thiscomb = 0;

$thiscomc = 0;

$timestamp = "";

$tc = "";

$today = "";

$timestamp = time();

$today = date("Y-m-d", $timestamp);

// end of variables //



if (isset($_POST["uid"]) == "") {

    $_POST["uid"] = "";

}



if (isset($_POST["tlvid"]) == "") {

    $_POST["tlvid"] = "";

}



if (isset($_POST["refcode"]) == "") {

    $_POST["refcode"] = "";

}



if (isset($_POST["uid"])) {

    $uid = $_POST["uid"];

}



if (isset($_POST["tlvid"])) {

    $tlvid = $_POST["tlvid"];

}



if (isset($_POST["refcode"])) {

    $refcode = $_POST["refcode"];

}


$sql =

    "SELECT level as ulevel from user_invitation_code where invcode = '" .

    $refcode .

    "' and status = 'new' limit 1";

$res = mysqli_query($conn, $sql);



if (mysqli_num_rows($res)) {

    while ($row = mysqli_fetch_array($res)) {

        $ulevel = $row["ulevel"];

    }

} else {

    $ulevel = "";

}



$sql =

    "SELECT teams.* FROM teams INNER JOIN total_commission on total_commission.uid = teams.uid WHERE teams.refcode = '" .

    $refcode .

    "' AND levelfrom = '" .

    $ulevel .

    "'  group by teams.uid ";



$res = mysqli_query($conn, $sql);



if (mysqli_num_rows($res)) {

    while ($row = mysqli_fetch_array($res)) {

        $tmid[$x] = $row["tmid"];

        $tuid[$x] = $row["uid"];

        $refid[$x] = $row["refid"];

        $retid[$x] = $row["retid"];

        $ulvidf[$x] = $row["ulvidf"];

        $ulvidt[$x] = $row["ulvidt"];

        $refc[$x] = $row["refcode"];

        $retc[$x] = $row["retcode"];

        $levelf[$x] = $row["levelfrom"];

        $levelt[$x] = $row["levelto"];



        $x++;

    }

} else {

    $tmid[$x] = "";

    $tuid[$x] = "";

    $refid[$x] = "";

    $retid[$x] = "";

    $ulvidf[$x] = "";

    $ulvidt[$x] = "";

    $refc[$x] = "";

    $retc[$x] = "";

    $levelf[$x] = "";

    $levelt[$x] = "";

}





foreach ($tuid as $key => $thistuid) {

    $thistmid = $tmid[$key];

    $thistuid = $tuid[$key];

    $thisrefid = $refid[$key];

    $thisretid = $retid[$key];

    $thisulvidf = $ulvidf[$key];

    $thisulvidt = $ulvidt[$key];

    $thisrefcode = $refc[$key];

    $thisretcode = $retc[$key];

    $thislevelf = $levelf[$key];

    $thislevelt = $levelt[$key];



    if ($thislevelf == 1 && $thislevelt == 1) {

        // tcom query //

        if ($tlvid == "") {

            $sql =

                "SELECT  IFNULL(sum(tc),0) as tc from total_commission WHERE uid = '" .

                $thistuid .

                "' AND iscancel = 0 AND refcode = '" .

                $thisretcode .

                "'";



            // result //

            $res = mysqli_query($conn, $sql);

            // end of result //



            // check true condition //

            if ($row = mysqli_fetch_array($res)) {

                $tc = $row["tc"];

                $thiscoma = floatval($tc);

            }

            // end of check true condition //

            else {

                //check false condition //

                $thiscoma = 0;

            } // end of check false condition //

        } else {

            $sql =

                "SELECT tlvid as tlid,utlvid as ultvid FROM user_tier_level WHERE uid = '" .

                $thistuid .

                "'";

            $res = mysqli_query($conn, $sql);

            if (mysqli_num_rows($res)) {

                while ($row = mysqli_fetch_array($res)) {

                    $tlid = $row["tlid"];

                    $utlvid = $row["ultvid"];

                    if ($tlid == 1) {

                        $sql =

                            "SELECT  IFNULL(sum(tc),0) as tc from total_commission WHERE uid = '" .

                            $thistuid .

                            "' AND tlvid = '" .

                            $utlvid .

                            "' AND iscancel = 0 AND refcode = '" .

                            $thisretcode .

                            "'";

                    }



                    if ($tlid == 2) {

                        $sql =

                            "SELECT  IFNULL(sum(tc),0) as tc from total_commission WHERE uid = '" .

                            $thistuid .

                            "' AND tlvid = '" .

                            $utlvid .

                            "' AND iscancel = 0 AND refcode = '" .

                            $thisretcode .

                            "'";

                    }



                    if ($tlid == 3) {

                        $sql =

                            "SELECT  IFNULL(sum(tc),0) as tc from total_commission WHERE uid = '" .

                            $thistuid .

                            "' AND tlvid = '" .

                            $utlvid .

                            "' AND iscancel = 0 AND refcode = '" .

                            $thisretcode .

                            "'";

                    }



                    if ($tlid == 4) {

                        $sql =

                            "SELECT  IFNULL(sum(tc),0) as tc from total_commission WHERE uid = '" .

                            $thistuid .

                            "' AND tlvid = '" .

                            $utlvid .

                            "' AND iscancel = 0 AND refcode = '" .

                            $thisretcode .

                            "'";

                    }

                    // result //

                    $res = mysqli_query($conn, $sql);

                    // end of result //



                    // check true condition //

                    if ($row = mysqli_fetch_array($res)) {

                        $tc = $row["tc"];

                        $thiscoma = floatval($tc);

                    }

                    // end of check true condition //

                    else {

                        //check false condition //

                        $thiscoma = 0;

                    } // end of check false condition //

                }

            }

        }



        if ($thiscoma != 0) {

            $thispcoma = floatval(16 / 100);

            $thistcoma = floatval($thispcoma * $thiscoma);

        } else {

            $thistcoma = 0;

        }

    }



    if ($thislevelf == 1 && $thislevelt == 2) {

        // tcom query //

        if ($tlvid == "") {

            $sql =

                "SELECT  IFNULL(sum(tc),0) as tc from total_commission WHERE uid = '" .

                $thistuid .

                "' AND iscancel = 0 AND refcode = '" .

                $thisretcode .

                "'";



            // result //

            $res = mysqli_query($conn, $sql);

            // end of result //



            // check true condition //

            if ($row = mysqli_fetch_array($res)) {

                $tc = $row["tc"];

                $thiscomb = floatval($tc);

            }

            // end of check true condition //

            else {

                //check false condition //

                $thiscomb = 0;

            } // end of check false condition //

        } else {

            $sql =

                "SELECT tlvid as tlid,utlvid as ultvid FROM user_tier_level WHERE uid = '" .

                $thistuid .

                "'";

            $res = mysqli_query($conn, $sql);

            if (mysqli_num_rows($res)) {

                while ($row = mysqli_fetch_array($res)) {

                    $tlid = $row["tlid"];

                    $utlvid = $row["ultvid"];

                    if ($tlid == 1) {

                        $sql =

                            "SELECT  IFNULL(sum(tc),0) as tc from total_commission WHERE uid = '" .

                            $thistuid .

                            "' AND tlvid = '" .

                            $utlvid .

                            "' AND iscancel = 0 AND refcode = '" .

                            $thisretcode .

                            "'";

                    }



                    if ($tlid == 2) {

                        $sql =

                            "SELECT  IFNULL(sum(tc),0) as tc from total_commission WHERE uid = '" .

                            $thistuid .

                            "' AND tlvid = '" .

                            $utlvid .

                            "' AND iscancel = 0 AND refcode = '" .

                            $thisretcode .

                            "'";

                    }



                    if ($tlid == 3) {

                        $sql =

                            "SELECT  IFNULL(sum(tc),0) as tc from total_commission WHERE uid = '" .

                            $thistuid .

                            "' AND tlvid = '" .

                            $utlvid .

                            "' AND iscancel = 0 AND refcode = '" .

                            $thisretcode .

                            "'";

                    }



                    if ($tlid == 4) {

                        $sql =

                            "SELECT  IFNULL(sum(tc),0) as tc from total_commission WHERE uid = '" .

                            $thistuid .

                            "' AND tlvid = '" .

                            $utlvid .

                            "' AND iscancel = 0 AND refcode = '" .

                            $thisretcode .

                            "'";

                    }

                    // result //

                    $res = mysqli_query($conn, $sql);

                    // end of result //



                    // check true condition //

                    if ($row = mysqli_fetch_array($res)) {

                        $tc = $row["tc"];

                        $thiscomb = floatval($tc);

                    }

                    // end of check true condition //

                    else {

                        //check false condition //

                        $thiscomb = 0;

                    } // end of check false condition //

                }

            }

        }



        if ($thiscomb != 0) {

            $thispcomb = (floatval) (8 / 100);

            $thistcomb = (floatval) ($thispcomb * $thiscomb);

        } else {

            $thistcomb = 0;

        }

    }



    if ($thislevelf == 1 && $thislevelt == 3) {

        // tcom query //

        if ($tlvid == "") {

            $sql =

                "SELECT  IFNULL(sum(tc),0) as tc from total_commission WHERE uid = '" .

                $thistuid .

                "' AND iscancel = 0 AND refcode = '" .

                $thisretcode .

                "'";



            // result //

            $res = mysqli_query($conn, $sql);

            // end of result //



            // check true condition //

            if ($row = mysqli_fetch_array($res)) {

                $tc = $row["tc"];

                $thiscomc = floatval($tc);

            }

            // end of check true condition //

            else {

                //check false condition //

                $thiscomc = 0;

            } // end of check false condition //

        } else {

            $sql =

                "SELECT tlvid as tlid,utlvid as ultvid FROM user_tier_level WHERE uid = '" .

                $thistuid .

                "'";

            $res = mysqli_query($conn, $sql);

            if (mysqli_num_rows($res)) {

                while ($row = mysqli_fetch_array($res)) {

                    $tlid = $row["tlid"];

                    $utlvid = $row["ultvid"];

                    if ($tlid == 1) {

                        $sql =

                            "SELECT  IFNULL(sum(tc),0) as tc from total_commission WHERE uid = '" .

                            $thistuid .

                            "' AND tlvid = '" .

                            $utlvid .

                            "' AND iscancel = 0 AND refcode = '" .

                            $thisretcode .

                            "'";

                    }



                    if ($tlid == 2) {

                        $sql =

                            "SELECT  IFNULL(sum(tc),0) as tc from total_commission WHERE uid = '" .

                            $thistuid .

                            "' AND tlvid = '" .

                            $utlvid .

                            "' AND iscancel = 0 AND refcode = '" .

                            $thisretcode .

                            "'";

                    }



                    if ($tlid == 3) {

                        $sql =

                            "SELECT  IFNULL(sum(tc),0) as tc from total_commission WHERE uid = '" .

                            $thistuid .

                            "' AND tlvid = '" .

                            $utlvid .

                            "' AND iscancel = 0 AND refcode = '" .

                            $thisretcode .

                            "'";

                    }



                    if ($tlid == 4) {

                        $sql =

                            "SELECT  IFNULL(sum(tc),0) as tc from total_commission WHERE uid = '" .

                            $thistuid .

                            "' AND tlvid = '" .

                            $utlvid .

                            "' AND iscancel = 0 AND refcode = '" .

                            $thisretcode .

                            "'";

                    }

                    // result //

                    $res = mysqli_query($conn, $sql);

                    // end of result //



                    // check true condition //

                    if ($row = mysqli_fetch_array($res)) {

                        $tc = $row["tc"];

                        $thiscomc = floatval($tc);

                    }

                    // end of check true condition //

                    else {

                        //check false condition //

                        $thiscomc = 0;

                    } // end of check false condition //

                }

            }

        }



        if ($thiscomc != 0) {

            $thispcomc = (floatval) (4 / 100);

            $thistcomc = (floatval) ($thispcomc * $thiscomc);

        } else {

            $thistcomc = 0;

        }

    }



    if ($thislevelf == 2 && $thislevelt == 1) {

        // tcom query //

        if ($tlvid == "") {

            $sql =

                "SELECT  IFNULL(sum(tc),0) as tc from total_commission WHERE uid = '" .

                $thistuid .

                "' AND iscancel = 0 AND refcode = '" .

                $thisretcode .

                "'";



            // result //

            $res = mysqli_query($conn, $sql);

            // end of result //



            // check true condition //

            if ($row = mysqli_fetch_array($res)) {

                $tc = $row["tc"];

                $thiscoma = floatval($tc);

            }

            // end of check true condition //

            else {

                //check false condition //

                $thiscoma = 0;

            } // end of check false condition //

        } else {

            $sql =

                "SELECT tlvid as tlid,utlvid as ultvid FROM user_tier_level WHERE uid = '" .

                $thistuid .

                "'";

            $res = mysqli_query($conn, $sql);

            if (mysqli_num_rows($res)) {

                while ($row = mysqli_fetch_array($res)) {

                    $tlid = $row["tlid"];

                    $utlvid = $row["ultvid"];

                    if ($tlid == 1) {

                        $sql =

                            "SELECT  IFNULL(sum(tc),0) as tc from total_commission WHERE uid = '" .

                            $thistuid .

                            "' AND tlvid = '" .

                            $utlvid .

                            "' AND iscancel = 0 AND refcode = '" .

                            $thisretcode .

                            "'";

                    }



                    if ($tlid == 2) {

                        $sql =

                            "SELECT  IFNULL(sum(tc),0) as tc from total_commission WHERE uid = '" .

                            $thistuid .

                            "' AND tlvid = '" .

                            $utlvid .

                            "' AND iscancel = 0 AND refcode = '" .

                            $thisretcode .

                            "'";

                    }



                    if ($tlid == 3) {

                        $sql =

                            "SELECT  IFNULL(sum(tc),0) as tc from total_commission WHERE uid = '" .

                            $thistuid .

                            "' AND tlvid = '" .

                            $utlvid .

                            "' AND iscancel = 0 AND refcode = '" .

                            $thisretcode .

                            "'";

                    }



                    if ($tlid == 4) {

                        $sql =

                            "SELECT  IFNULL(sum(tc),0) as tc from total_commission WHERE uid = '" .

                            $thistuid .

                            "' AND tlvid = '" .

                            $utlvid .

                            "' AND iscancel = 0 AND refcode = '" .

                            $thisretcode .

                            "'";

                    }

                    // result //

                    $res = mysqli_query($conn, $sql);

                    // end of result //



                    // check true condition //

                    if ($row = mysqli_fetch_array($res)) {

                        $tc = $row["tc"];

                        $thiscoma = floatval($tc);

                    }

                    // end of check true condition //

                    else {

                        //check false condition //

                        $thiscoma = 0;

                    } // end of check false condition //

                }

            }

        }



        if ($thiscoma != 0) {

            $thispcoma = floatval(16 / 100);

            $thistcoma = floatval($thispcoma * $thiscoma);

        } else {

            $thistcoma = 0;

        }

    }



    if ($thislevelf == 2 && $thislevelt == 2) {

        // tcom query //

        if ($tlvid == "") {

            $sql =

                "SELECT  IFNULL(sum(tc),0) as tc from total_commission WHERE uid = '" .

                $thistuid .

                "' AND iscancel = 0 AND refcode = '" .

                $thisretcode .

                "'";



            // result //

            $res = mysqli_query($conn, $sql);

            // end of result //



            // check true condition //

            if ($row = mysqli_fetch_array($res)) {

                $tc = $row["tc"];

                $thiscomb = floatval($tc);

            }

            // end of check true condition //

            else {

                //check false condition //

                $thiscomb = 0;

            } // end of check false condition //

        } else {

            $sql =

                "SELECT tlvid as tlid,utlvid as ultvid FROM user_tier_level WHERE uid = '" .

                $thistuid .

                "'";

            $res = mysqli_query($conn, $sql);

            if (mysqli_num_rows($res)) {

                while ($row = mysqli_fetch_array($res)) {

                    $tlid = $row["tlid"];

                    $utlvid = $row["ultvid"];

                    if ($tlid == 1) {

                        $sql =

                            "SELECT  IFNULL(sum(tc),0) as tc from total_commission WHERE uid = '" .

                            $thistuid .

                            "' AND tlvid = '" .

                            $utlvid .

                            "' AND iscancel = 0 AND refcode = '" .

                            $thisretcode .

                            "'";

                    }



                    if ($tlid == 2) {

                        $sql =

                            "SELECT  IFNULL(sum(tc),0) as tc from total_commission WHERE uid = '" .

                            $thistuid .

                            "' AND tlvid = '" .

                            $utlvid .

                            "' AND iscancel = 0 AND refcode = '" .

                            $thisretcode .

                            "'";

                    }



                    if ($tlid == 3) {

                        $sql =

                            "SELECT  IFNULL(sum(tc),0) as tc from total_commission WHERE uid = '" .

                            $thistuid .

                            "' AND tlvid = '" .

                            $utlvid .

                            "' AND iscancel = 0 AND refcode = '" .

                            $thisretcode .

                            "'";

                    }



                    if ($tlid == 4) {

                        $sql =

                            "SELECT  IFNULL(sum(tc),0) as tc from total_commission WHERE uid = '" .

                            $thistuid .

                            "' AND tlvid = '" .

                            $utlvid .

                            "' AND iscancel = 0 AND refcode = '" .

                            $thisretcode .

                            "'";

                    }

                    // result //

                    $res = mysqli_query($conn, $sql);

                    // end of result //



                    // check true condition //

                    if ($row = mysqli_fetch_array($res)) {

                        $tc = $row["tc"];

                        $thiscomb = floatval($tc);

                    }

                    // end of check true condition //

                    else {

                        //check false condition //

                        $thiscomb = 0;

                    } // end of check false condition //

                }

            }

        }



        if ($thiscomb != 0) {

            $thispcomb = (floatval) (8 / 100);

            $thistcomb = (floatval) ($thispcomb * $thiscomb);

        } else {

            $thistcomb = 0;

        }

    }



    if ($thislevelf == 2 && $thislevelt == 3) {

        // tcom query //

        if ($tlvid == "") {

            $sql =

                "SELECT  IFNULL(sum(tc),0) as tc from total_commission WHERE uid = '" .

                $thistuid .

                "' AND iscancel = 0 AND refcode = '" .

                $thisretcode .

                "'";



            // result //

            $res = mysqli_query($conn, $sql);

            // end of result //



            // check true condition //

            if ($row = mysqli_fetch_array($res)) {

                $tc = $row["tc"];

                $thiscomc = floatval($tc);

            }

            // end of check true condition //

            else {

                //check false condition //

                $thiscomc = 0;

            } // end of check false condition //

        } else {

            $sql =

                "SELECT tlvid as tlid,utlvid as ultvid FROM user_tier_level WHERE uid = '" .

                $thistuid .

                "'";

            $res = mysqli_query($conn, $sql);

            if (mysqli_num_rows($res)) {

                while ($row = mysqli_fetch_array($res)) {

                    $tlid = $row["tlid"];

                    $utlvid = $row["ultvid"];

                    if ($tlid == 1) {

                        $sql =

                            "SELECT  IFNULL(sum(tc),0) as tc from total_commission WHERE uid = '" .

                            $thistuid .

                            "' AND tlvid = '" .

                            $utlvid .

                            "' AND iscancel = 0 AND refcode = '" .

                            $thisretcode .

                            "'";

                    }



                    if ($tlid == 2) {

                        $sql =

                            "SELECT  IFNULL(sum(tc),0) as tc from total_commission WHERE uid = '" .

                            $thistuid .

                            "' AND tlvid = '" .

                            $utlvid .

                            "' AND iscancel = 0 AND refcode = '" .

                            $thisretcode .

                            "'";

                    }



                    if ($tlid == 3) {

                        $sql =

                            "SELECT  IFNULL(sum(tc),0) as tc from total_commission WHERE uid = '" .

                            $thistuid .

                            "' AND tlvid = '" .

                            $utlvid .

                            "' AND iscancel = 0 AND refcode = '" .

                            $thisretcode .

                            "'";

                    }



                    if ($tlid == 4) {

                        $sql =

                            "SELECT  IFNULL(sum(tc),0) as tc from total_commission WHERE uid = '" .

                            $thistuid .

                            "' AND tlvid = '" .

                            $utlvid .

                            "' AND iscancel = 0 AND refcode = '" .

                            $thisretcode .

                            "'";

                    }

                    // result //

                    $res = mysqli_query($conn, $sql);

                    // end of result //



                    // check true condition //

                    if ($row = mysqli_fetch_array($res)) {

                        $tc = $row["tc"];

                        $thiscomc = floatval($tc);

                    }

                    // end of check true condition //

                    else {

                        //check false condition //

                        $thiscomc = 0;

                    } // end of check false condition //

                }

            }

        }



        if ($thiscomc != 0) {

            $thispcomc = (floatval) (4 / 100);

            $thistcomc = (floatval) ($thispcomc * $thiscomc);

        } else {

            $thistcomc = 0;

        }

    }



    if ($thislevelf == 3 && $thislevelt == 1) {

        // tcom query //

        if ($tlvid == "") {

            $sql =

                "SELECT  IFNULL(sum(tc),0) as tc from total_commission WHERE uid = '" .

                $thistuid .

                "' AND iscancel = 0 AND refcode = '" .

                $thisretcode .

                "'";



            // result //

            $res = mysqli_query($conn, $sql);

            // end of result //



            // check true condition //

            if ($row = mysqli_fetch_array($res)) {

                $tc = $row["tc"];

                $thiscoma = floatval($tc);

            }

            // end of check true condition //

            else {

                //check false condition //

                $thiscoma = 0;

            } // end of check false condition //

        } else {

            $sql =

                "SELECT tlvid as tlid,utlvid as ultvid FROM user_tier_level WHERE uid = '" .

                $thistuid .

                "'";

            $res = mysqli_query($conn, $sql);

            if (mysqli_num_rows($res)) {

                while ($row = mysqli_fetch_array($res)) {

                    $tlid = $row["tlid"];

                    $utlvid = $row["ultvid"];

                    if ($tlid == 1) {

                        $sql =

                            "SELECT  IFNULL(sum(tc),0) as tc from total_commission WHERE uid = '" .

                            $thistuid .

                            "' AND tlvid = '" .

                            $utlvid .

                            "' AND iscancel = 0 AND refcode = '" .

                            $thisretcode .

                            "'";

                    }



                    if ($tlid == 2) {

                        $sql =

                            "SELECT  IFNULL(sum(tc),0) as tc from total_commission WHERE uid = '" .

                            $thistuid .

                            "' AND tlvid = '" .

                            $utlvid .

                            "' AND iscancel = 0 AND refcode = '" .

                            $thisretcode .

                            "'";

                    }



                    if ($tlid == 3) {

                        $sql =

                            "SELECT  IFNULL(sum(tc),0) as tc from total_commission WHERE uid = '" .

                            $thistuid .

                            "' AND tlvid = '" .

                            $utlvid .

                            "' AND iscancel = 0 AND refcode = '" .

                            $thisretcode .

                            "'";

                    }



                    if ($tlid == 4) {

                        $sql =

                            "SELECT  IFNULL(sum(tc),0) as tc from total_commission WHERE uid = '" .

                            $thistuid .

                            "' AND tlvid = '" .

                            $utlvid .

                            "' AND iscancel = 0 AND refcode = '" .

                            $thisretcode .

                            "'";

                    }

                    // result //

                    $res = mysqli_query($conn, $sql);

                    // end of result //



                    // check true condition //

                    if ($row = mysqli_fetch_array($res)) {

                        $tc = $row["tc"];

                        $thiscoma = floatval($tc);

                    }

                    // end of check true condition //

                    else {

                        //check false condition //

                        $thiscoma = 0;

                    } // end of check false condition //

                }

            }

        }



        if ($thiscoma != 0) {

            $thispcoma = floatval(16 / 100);

            $thistcoma = floatval($thispcoma * $thiscoma);

        } else {

            $thistcoma = 0;

        }

    }



    if ($thislevelf == 3 && $thislevelt == 2) {

        // tcom query //

        if ($tlvid == "") {

            $sql =

                "SELECT  IFNULL(sum(tc),0) as tc from total_commission WHERE uid = '" .

                $thistuid .

                "' AND iscancel = 0 AND refcode = '" .

                $thisretcode .

                "'";



            // result //

            $res = mysqli_query($conn, $sql);

            // end of result //



            // check true condition //

            if ($row = mysqli_fetch_array($res)) {

                $tc = $row["tc"];

                $thiscomb = floatval($tc);

            }

            // end of check true condition //

            else {

                //check false condition //

                $thiscomb = 0;

            } // end of check false condition //

        } else {

            $sql =

                "SELECT tlvid as tlid,utlvid as ultvid FROM user_tier_level WHERE uid = '" .

                $thistuid .

                "'";

            $res = mysqli_query($conn, $sql);

            if (mysqli_num_rows($res)) {

                while ($row = mysqli_fetch_array($res)) {

                    $tlid = $row["tlid"];

                    $utlvid = $row["ultvid"];

                    if ($tlid == 1) {

                        $sql =

                            "SELECT  IFNULL(sum(tc),0) as tc from total_commission WHERE uid = '" .

                            $thistuid .

                            "' AND tlvid = '" .

                            $utlvid .

                            "' AND iscancel = 0 AND refcode = '" .

                            $thisretcode .

                            "'";

                    }



                    if ($tlid == 2) {

                        $sql =

                            "SELECT  IFNULL(sum(tc),0) as tc from total_commission WHERE uid = '" .

                            $thistuid .

                            "' AND tlvid = '" .

                            $utlvid .

                            "' AND iscancel = 0 AND refcode = '" .

                            $thisretcode .

                            "'";

                    }



                    if ($tlid == 3) {

                        $sql =

                            "SELECT  IFNULL(sum(tc),0) as tc from total_commission WHERE uid = '" .

                            $thistuid .

                            "' AND tlvid = '" .

                            $utlvid .

                            "' AND iscancel = 0 AND refcode = '" .

                            $thisretcode .

                            "'";

                    }



                    if ($tlid == 4) {

                        $sql =

                            "SELECT  IFNULL(sum(tc),0) as tc from total_commission WHERE uid = '" .

                            $thistuid .

                            "' AND tlvid = '" .

                            $utlvid .

                            "' AND iscancel = 0 AND refcode = '" .

                            $thisretcode .

                            "'";

                    }

                    // result //

                    $res = mysqli_query($conn, $sql);

                    // end of result //



                    // check true condition //

                    if ($row = mysqli_fetch_array($res)) {

                        $tc = $row["tc"];

                        $thiscomb = floatval($tc);

                    }

                    // end of check true condition //

                    else {

                        //check false condition //

                        $thiscomb = 0;

                    } // end of check false condition //

                }

            }

        }



        if ($thiscomb != 0) {

            $thispcomb = (floatval) (8 / 100);

            $thistcomb = (floatval) ($thispcomb * $thiscomb);

        } else {

            $thistcomb = 0;

        }

    }



    if ($thislevelf == 3 && $thislevelt == 3) {

        // tcom query //

        if ($tlvid == "") {

            $sql =

                "SELECT  IFNULL(sum(tc),0) as tc from total_commission WHERE uid = '" .

                $thistuid .

                "' AND iscancel = 0 AND refcode = '" .

                $thisretcode .

                "'";



            // result //

            $res = mysqli_query($conn, $sql);

            // end of result //



            // check true condition //

            if ($row = mysqli_fetch_array($res)) {

                $tc = $row["tc"];

                $thiscomc = floatval($tc);

            }

            // end of check true condition //

            else {

                //check false condition //

                $thiscomc = 0;

            } // end of check false condition //

        } else {

            $sql =

                "SELECT tlvid as tlid,utlvid as ultvid FROM user_tier_level WHERE uid = '" .

                $thistuid .

                "'";

            $res = mysqli_query($conn, $sql);

            if (mysqli_num_rows($res)) {

                while ($row = mysqli_fetch_array($res)) {

                    $tlid = $row["tlid"];

                    $utlvid = $row["ultvid"];

                    if ($tlid == 1) {

                        $sql =

                            "SELECT  IFNULL(sum(tc),0) as tc from total_commission WHERE uid = '" .

                            $thistuid .

                            "' AND tlvid = '" .

                            $utlvid .

                            "' AND iscancel = 0 AND refcode = '" .

                            $thisretcode .

                            "'";

                    }



                    if ($tlid == 2) {

                        $sql =

                            "SELECT  IFNULL(sum(tc),0) as tc from total_commission WHERE uid = '" .

                            $thistuid .

                            "' AND tlvid = '" .

                            $utlvid .

                            "' AND iscancel = 0 AND refcode = '" .

                            $thisretcode .

                            "'";

                    }



                    if ($tlid == 3) {

                        $sql =

                            "SELECT  IFNULL(sum(tc),0) as tc from total_commission WHERE uid = '" .

                            $thistuid .

                            "' AND tlvid = '" .

                            $utlvid .

                            "' AND iscancel = 0 AND refcode = '" .

                            $thisretcode .

                            "'";

                    }



                    if ($tlid == 4) {

                        $sql =

                            "SELECT  IFNULL(sum(tc),0) as tc from total_commission WHERE uid = '" .

                            $thistuid .

                            "' AND tlvid = '" .

                            $utlvid .

                            "' AND iscancel = 0 AND refcode = '" .

                            $thisretcode .

                            "'";

                    }

                    // result //

                    $res = mysqli_query($conn, $sql);

                    // end of result //



                    // check true condition //

                    if ($row = mysqli_fetch_array($res)) {

                        $tc = $row["tc"];

                        $thiscomc = floatval($tc);

                    }

                    // end of check true condition //

                    else {

                        //check false condition //

                        $thiscomc = 0;

                    } // end of check false condition //

                }

            }

        }



        if ($thiscomc != 0) {

            $thispcomc = (floatval) (4 / 100);

            $thistcomc = (floatval) ($thispcomc * $thiscomc);

        } else {

            $thistcomc = 0;

        }

    }

    $data = [

        "pcoma" => $thispcoma,

        "pcomb" => $thispcomb,

        "pcomc" => $thispcomc,

        "ocoma" => $thiscoma,

        "ocomb" => $thiscomb,

        "ocomc" => $thiscomc,

        "coma" => $thistcoma,

        "comb" => $thistcomb,

        "comc" => $thistcomc,

    ];

}
echo json_encode($data);
?>