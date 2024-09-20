<?php
// view withdrawal report //
// include session //
include_once "../session/session.php"; // this is used for include session //
// end of include session //
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
$startFrom = 0;
$key = 0;
$all_qry = "";
$result = "";
$where = "";
$and_like = "";
$sql = "";
$limit = "";
$next = "";
$previous = "";
$paginationHtml = "";
$search = "";
$type = "";
$thislabel = "";
$paginationCtrls = "";
$thisrefcode = "";
$thiswithdrawalby = "";
$thisname = "";
$thisphone = "";
$thisemail = "";
$thistxid = "";
$thisuid = "";
$thisutxid = "";
$thiswithdrawal = "";
$thismethod = "";
$thisstatus = "";
$thishref = "";
$thiswhref = "";
$thisdetails = "";
$thismsglabel = "";
$thisheading = "";
$thischeckaction = "";
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

if ($type == "acswithdrawal" && $search == "" || $search != "") {
    $all_qry =
        "SELECT * from withdrawal INNER JOIN topup_method on topup_method.tpmid = withdrawal.tpmid order by withdrawal.wtid desc";
    $thismsglabel = "There is no withdrawal report found";
    $thisheading = "Withdrawal Report";
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
        $previous = $pagenum - 1;
        $paginationCtrls .=
            '<a data-page="' .
            $previous .
            '" class="btn btn-default btn-page">Previous</a> &nbsp;';
    }
    if ($page > 1 && $page != "") {
        $previous = $page - 1;
        $paginationCtrls .=
            '<a data-page="' .
            $previous .
            '" class="btn btn-default btn-page">Previous</a> &nbsp;';
    }
    for ($i = $pagenum - 4; $i < $pagenum; $i++) {
    }

    $paginationCtrls .=
        '<a data-page="' .
        $pagenum .
        '" class="btn btn-default btn-page">' .
        $i .
        "</a> &nbsp;";
    for ($i = $pagenum + 1; $i <= $totalPages; $i++) {
        $paginationCtrls .=
            '<a data-page="' .
            $i .
            '" class="btn btn-default btn-page">' .
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

if ($type == "acswithdrawal" && $search == "" || $search != "") {
    $all_qry = "SELECT * from withdrawal INNER JOIN topup_method on topup_method.tpmid = withdrawal.tpmid order by withdrawal.wtid desc $limit";
    $thismsglabel = "There is no withdrawal report found ";
    $thisheading = "Withdrawal Report";
}

mysqli_query($conn, "set character_set_results='utf8'");
$res = mysqli_query($conn, $all_qry);
$sql = $res;
$total = mysqli_num_rows($sql);
if (mysqli_num_rows($sql)) {
    $thislabel =
        '<strong class="result"> Showing ' .
        $total .
        " of " .
        $totalRecords .
        " entries </strong>"; ?>
           <?php echo $thislabel; ?>
                                  <div class="row">
                                  <div class="col-sm-12">
                                    <h2 style="text-align: center;"><strong><?php echo $thisheading; ?></strong></h2>
                                  </div>
                                 </div>

  <table class="table table-striped table-bordered new-table" id="table">   

<?php if ($type == "acswithdrawal") { ?>
                                    <thead>
                                       <tr>
                                          <th>Real Name</th>
                                          <th>Phone</th>
                                          <th>Email</th>
                                          <th>Ref Code</th>
                                          <th>Transaction ID</th>
                                          <th>Method</th>
                                          <th>Withdrawal</th>
                                          <th>Status</th>
                                       </tr>
                                    </thead>      
 <?php } ?>

                                    <tbody>
       
   <?php foreach ($sql as $key => $row) {
       $key++;
       $uid = $row["uid"];
       $wtid = $row["wtid"];
       $realname = $row["realname"];
       $phone = $row["phone"];
       $email = $row["email"];
       $refcode = $row["refcode"];
       $txid = $row["txid"];
       $utxid = $row["utxid"];
       $tpmethod = $row["tpmethod"];
       $withdrawal = $row["withdrawal"];
       $withdrawalby = $row["withdrawalby"];
       $withdrawaldate = $row["withdrawaldate"];
       $isnew = $row["isnew"];
       $isapprove = $row["isapprove"];
       $thisname = $realname;
       $thisphone = $phone;
       empty($email)
           ? ($thisemail = "----------------------")
           : ($thisemail = $email);
       $thistxid = $txid;
       $thisuid = $uid;
       $thisutxid = $utxid;
       $thismethod = $tpmethod;
       $thisrefcode = $refcode;
       $thiswithdrawalby = $withdrawalby;
       $thiswithdrawal = $withdrawal . "-" . "USDT";
       empty($realname)
           ? ($thiswhref = "null")
           : ($thiswhref =
               '<a href="details/withdrawal-details.php?detail=' .
               $wtid .
               '">' .
               $thisname .
               "</a>");
       if ($isnew == 1) {
           $thisstatus =
               '<strong style="color:#4285F4!important;">New</strong>';
      
       } elseif ($isapprove == 1) {
           $thisstatus =
               '<strong style="color:#089000!important;">Completed</strong>';
           $thischeckaction = "";
       } elseif ($isapprove == 0) {
           $thisstatus =
               '<strong style="color:#DB4473!important;">Cancelled</strong>';
           $thischeckaction = "";
       }
       $thisdetails = $thiswhref;

       if ($type == "acswithdrawal") {
           $paginationHtml .= "<tr>";
           $paginationHtml .= "<td>" . $thisdetails . "</td>";
           $paginationHtml .= "<td>" . $thisphone . "</td>";
           $paginationHtml .= "<td>" . $thisemail . "</td>";
           $paginationHtml .= "<td>" . $thisrefcode . "</td>";
           $paginationHtml .= "<td>" . $thistxid . "</td>";
           $paginationHtml .= "<td>" . $thismethod . "</td>";
           $paginationHtml .= "<td>" . $thiswithdrawal . "</td>";
           $paginationHtml .= "<td>" . $thisstatus . "</td>";
           $paginationHtml .= "</tr>";
       }
   }
} else {
    if ($search != "") {
        $paginationHtml =
            '<div class="row"></div><div class="col-sm-12"><strong>There is no withdrawal report found of ' .
            $search .
            "</strong></div>";
    } else {
        $paginationHtml =
            '<div class="row"></div><div class="col-sm-12"><strong>' .
            $thismsglabel .
            "</strong></div>";
    }
    $paginationCtrls = "";
}
echo $paginationHtml;
?>
</tbody>
</table>
 <div id="pagination" class="pagination"><?php echo $paginationCtrls; ?></div>
 </div>
