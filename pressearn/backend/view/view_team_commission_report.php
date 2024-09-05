<?php
// view team commission report //

// include conn //
include_once "../../conn/conn.php";
// this is used for include conn //
// end of include conn //
?>
<div class="table-responsive">   
<?php
// variables //
$perPage = 10;
$page = 0;
$totalRecords = 0;
$totalPages = 0;
$total = 0;
$tsum = 0;
$trsum = 0;
$startFrom = 0;
$key = 0;
$all_qry = "";
$result = "";
$where = "";
$and_like = "";
$sql = "";
$limit = "";
$next = "";
$Pre = "";
$paginationHtml = "";
$search = "";
$type = "";
$uid = "";
$thislabel = "";
$paginationCtrls = "";
$ddate = "";
$commission = "";
$isapprove = "";
$thisddate = "";
$downlinelv = "";
$thistrefcode = "";
$thisdnlv = "";
$thiscommissionby = "";
$thisstatus = "";
$thismsglabel = "";
$thisheading = "";
$thisdate = "";
$target = "";
$thisimg = "";
$activeclass = "";
$defaultclass = "";
$tuid = [];
$comuid = [];
$thistuid = "";
$thiscomuid = "";
$x = 0;
$y = 0;

// end of variables //
if (isset($_POST["page"])) {
    $page = $_POST["page"];
}

if (isset($_POST["type"])) {
    $type = $_POST["type"];
}

if (isset($_POST["search"])) {
    $search = $_POST["search"];
}

$sql =
    "SELECT teams.uid from teams INNER JOIN commission_history on commission_history.uid = teams.uid group by teams.uid";
$res = mysqli_query($conn, $sql);

if (mysqli_num_rows($res)) {
    while ($row = mysqli_fetch_array($res)) {
        $tuid[$x] = $row["uid"];
        $x++;
    }
} else {
    $tuid[$x] = "";
}

$sql =
    "SELECT commission_history.uid as comuid FROM commission_history INNER JOIN teams on teams.uid = commission_history.uid GROUP BY teams.uid";
$res = mysqli_query($conn, $sql);

if (mysqli_num_rows($res)) {
    while ($row = mysqli_fetch_array($res)) {
        $comuid[$y] = $row["comuid"];
        $y++;
    }
} else {
    $comuid[$y] = "";
}
if($comuid == $tuid){
foreach ($tuid as $key => $thistuid) {
    $thistuid = $tuid[$key];
    if ($type == "tmscommission" && $search == "" || $search != "") {
         $all_qry =
            "SELECT users.uname as uname,(SELECT user_assign_level.levelto from user_assign_level WHERE user_assign_level.uid = users.userid LIMIT 1) as downlinelv,(SELECT user_assign_level.retcode from user_assign_level WHERE user_assign_level.uid = users.userid LIMIT 1) as trefcode,orders.*,product_images.pname,product_images.pimg from orders INNER JOIN product_images on product_images.oid = orders.oid INNER JOIN users on users.userid = orders.uid INNER JOIN commission_history on commission_history.oid = orders.oid where orders.uid = '" .
            $thistuid .
            "' order by orders.oid desc";
        $thismsglabel = "There is no team commission report found";
        $thisheading = "Team Commission Report";
    }

    $res = mysqli_query($conn, $all_qry);
    $totalRecords = mysqli_num_rows($res);
    $totalPages = ceil($totalRecords / $perPage);

    if ($totalPages < 1) {
        $totalPages = 1;
    }
    $pagenum = 1;

    if ($pagenum < 1) {
        $pagenum = 1;
    } elseif ($pagenum > $totalPages) {
        $pagenum = $totalPages;
    }

    if ($page == "") {
        $startFrom = ($pagenum - 1) * $perPage;
    } else {
        $startFrom = ($page - 1) * $perPage;
    }

    $paginationCtrls = "";

    if ($totalPages != 1) {
        if ($pagenum > 1 && $page == "") {
            $Pre = $pagenum - 1;
            $paginationCtrls .=
                '<a data-page="' .
                $Pre .
                '" class="btn btn-default btn-page">Pre</a> &nbsp;';
        }
        if ($page > 1 && $page != "") {
            $Pre = $page - 1;
            $paginationCtrls .=
                '<a data-page="' .
                $Pre .
                '" class="btn btn-default btn-page">Pre</a> &nbsp;';
        }
        for ($i = 1; $i <= $totalPages; $i++) {
            if ($page == "" && $i == 1) {
                $defaultclass =
                    'style="background-color: #110863 !important;color: #fffd;"';
            } else {
                $defaultclass = "";
            }
            if ($page == $i) {
                $activeclass =
                    'style="background-color: #110863 !important;color: #fffd;"';
            } else {
                $activeclass =
                    'style="background-color: #fff;border-color: #ccc;"';
            }
            $paginationCtrls .=
                '<a data-page="' .
                $i .
                '" class="btn btn-default btn-page" ' .
                $defaultclass .
                " " .
                $activeclass .
                " >" .
                $i .
                "</a> &nbsp; ";
        }
        if ($page == "" && $pagenum != $totalPages) {
            $next = $pagenum + 1;
            $style = 'style="pointer-events:default; cursor:pointer;"';
        }
        if ($page != "" && $page != $totalPages) {
            $next = $page + 1;
            $style = 'style="pointer-events:default; cursor:pointer;"';
        }
        if ($page == $totalPages) {
            $style = 'style="pointer-events:none; cursor:default;"';
        }
        $paginationCtrls .=
            ' &nbsp; &nbsp; <a data-page="' .
            $next .
            '" class="btn btn-default btn-next" ' .
            $style .
            ">Next</a> ";
    }

    $limit = "limit $startFrom,$perPage ";

    $sql = $res;
    $total = mysqli_num_rows($sql);
    $tsum += (int) $total;
    $trsum += (int) $totalRecords;
}

if (mysqli_num_rows($sql)) {
    $thislabel =
        '<strong class="result"> Showing ' .
        $tsum .
        " of " .
        $trsum .
        " entries </strong>"; ?>
           <?php echo $thislabel; ?>
                                  <div class="row">
                                  <div class="col-sm-12">
                                    <h2 style="text-align: center;"><strong><?php echo $thisheading; ?></strong></h2>
                                  </div>
                                 </div>


        <table class="table table-striped table-bordered all-table" id="table">                    
                                    <thead>
                                       <tr>
                                          <th>User Name</th>
                                          <th>Ref Code</th>
<!--                                           <th>Downline lv</th> -->
                                          <th>Order Date</th>
                                          <th>Order No</th>
                                          <th>Image</th>
                                          <th>Product</th>
                                          <th>Commission</th>
                                          <th>Status</th>
                                       </tr>
                                    </thead>
<?php
}
?>
<tbody>
<?php
foreach ($tuid as $key => $thistuid) {
    $thistuid = $tuid[$key];

    if ($type == "tmscommission" && $search == "" || $search != "") {
        $all_qry =
            "SELECT users.uname as uname,(SELECT user_assign_level.levelto from user_assign_level WHERE user_assign_level.uid = users.userid LIMIT 1) as downlinelv,(SELECT user_assign_level.retcode from user_assign_level WHERE user_assign_level.uid = users.userid LIMIT 1) as trefcode,orders.*,product_images.pname,product_images.pimg from orders INNER JOIN product_images on product_images.oid = orders.oid INNER JOIN users on users.userid = orders.uid INNER JOIN commission_history on commission_history.oid = orders.oid where orders.uid = '" .
            $thistuid .
            "' order by orders.oid desc $limit";
        $thismsglabel = "There is no team commission report found";
        $thisheading = "Team Commission Report";
    }

    mysqli_query($conn, "set character_set_results='utf8'");
    $res = mysqli_query($conn, $all_qry);
    $sql = $res;
    if (mysqli_num_rows($sql)) { ?>  

   <?php foreach ($sql as $key => $row) {
       $key++;
       $uid = $row["uid"];
       $oid = $row["oid"];
       $ono = $row["ono"];
       $odate = $row["orderdate"];
       $otime = $row["ordertime"];
       $pname = $row["pname"];
       $pimg = $row["pimg"];
       $trefcode = $row["trefcode"];
       $downlinelv = $row["downlinelv"];
       $amount = $row["amount"];
       $orderby = $row["uname"];
       $iscomplete = $row["iscomplete"];
       $iscancel = $row["iscancel"];
       $status = $row["status"];
       $thisono = $ono;
       $thispname = $pname;
       $thispimg = $pimg;
       $thisamount = $amount;
       $thiscommissionby = $orderby;

       $thisono = $ono;
       $thisodate = $odate;
       $thisotime = $otime;
       $thisdate = date_create($thisodate);
       $thisdate = date_format($thisdate, "d-m-Y");
       $thisodatetime = $thisdate . " " . $thisotime;
       $thisamount = '$' . $amount;
       $target = "../images/product-images/" . $thispimg;
       empty($thispimg)
           ? ($thisimg = "")
           : ($thisimg = ' <img src="' . $target . '" alt="" style="width:50px; height:50px;">');
       file_exists($target)
           ? ($thisimg = "")
           : ($thisimg = '<img src="' . $target . '" alt="" style="width:50px; height:50px;">');
       empty($thispname) ? ($thispname = "") : ($thispname = $thispname);
       empty($trefcode) ? ($thistrefcode = "") : ($thistrefcode = $trefcode);
       if ($iscomplete == 0) {
           $thisstatus =
               '<strong style="color:#4285F4!important;">Pending</strong>';
       }
       if ($iscomplete == 1) {
           $thisstatus =
               '<strong style="color:#089000!important;">Completed</strong>';
       }

       if ($iscancel == 1) {
           $thisstatus =
               '<strong style="color:#DB4473!important;">Cancelled</strong>';
       }
       if ($downlinelv == 1) {
           $thisdnlv = "Downline lv 1";
       }

       if ($downlinelv == 2) {
           $thisdnlv = "Downline lv 2";
       }

       if ($downlinelv == 3) {
           $thisdnlv = "Downline lv 3";
       }

       $paginationHtml .= "<tr>";
       $paginationHtml .= "<td>" . $thiscommissionby . "</td>";
       $paginationHtml .= "<td>" . $thistrefcode . "</td>";
       // $paginationHtml .= "<td>" . $thisdnlv . "</td>";
       $paginationHtml .= "<td>" . $thisodatetime . "</td>";
       $paginationHtml .= "<td>" . $thisono . "</td>";
       $paginationHtml .= "<td>" . $thisimg . "</td>";
       $paginationHtml .= "<td>" . $thispname . "</td>";
       $paginationHtml .= "<td>" . $thisamount . "</td>";
       $paginationHtml .= "<td>" . $thisstatus . "</td>";
       $paginationHtml .= "</tr>";
   }} else {if ($search != "") {
            $paginationHtml =
                '<div class="row"></div><div class="col-sm-12"><strong>There is no team commission report found of ' .
                $search .
                "</strong></div>";
        } else {
            $paginationHtml =
                '<div class="row"></div><div class="col-sm-12"><strong>' .
                $thismsglabel .
                "</strong></div>";
        }
        $paginationCtrls = "";}
}
}

echo $paginationHtml;
?>
</tbody>
</table>
 <div id="pagination" class="pagination"><?php echo $paginationCtrls; ?></div>
 </div>
