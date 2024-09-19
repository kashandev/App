<?php

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



if ($type == "new" && $search == "" || $search != "") {

    $all_qry =

        "SELECT * from withdrawal INNER JOIN topup_method on topup_method.tpmid = withdrawal.tpmid where withdrawal.isnew = 1  order by withdrawal.wtid desc";

    $thismsglabel = "There is no pending withdrawal found";

    $thisheading = "New";

}

if ($type == "comp" && $search == "" || $search != "") {

    $all_qry =

        "SELECT * from withdrawal INNER JOIN topup_method on topup_method.tpmid = withdrawal.tpmid where withdrawal.iswithdrawal = 1 and withdrawal.isapprove = 1 order by withdrawal.wtid desc ";

    $thismsglabel = "There is no approved withdrawal found";

    $thisheading = "Approved";

}

if ($type == "can" && $search == "" || $search != "") {

    $all_qry =

        "SELECT * from withdrawal INNER JOIN topup_method on topup_method.tpmid = withdrawal.tpmid where withdrawal.isreject = 1 order by withdrawal.wtid desc";

    $thismsglabel = "There is no rejected withdrawal found";

    $thisheading = "Cancelled";

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



if ($type == "new" && $search == "" || $search != "") {

    $all_qry = "SELECT * from withdrawal INNER JOIN topup_method on topup_method.tpmid = withdrawal.tpmid where withdrawal.isnew = 1 order by withdrawal.wtid desc $limit";

    $thismsglabel = "There is no new withdrawal found ";

    $thisheading = "New";

}



if ($type == "comp" && $search == "" || $search != "") {

    $all_qry = "SELECT * from withdrawal INNER JOIN topup_method on topup_method.tpmid = withdrawal.tpmid where withdrawal.iswithdrawal = 1 and withdrawal.isapprove = 1 order by withdrawal.wtid desc $limit";

    $thismsglabel = "There is no Approved withdrawal found";

    $thisheading = "Approved";

}



if ($type == "can" && $search == "" || $search != "") {

    $all_qry = "SELECT * from withdrawal INNER JOIN topup_method on topup_method.tpmid = withdrawal.tpmid where withdrawal.isreject = 1 order by withdrawal.wtid desc $limit ";

    $thismsglabel = "There is no cancelled withdrawal found";

    $thisheading = "Cancelled";

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



<?php if ($type == "new") { ?>



                         <div class="row" id="button-div">  

                        <div class="col-sm-8"> <button type="button" class="btn btn-primary btn-approve" disabled=""> <i class="fa fa-check"></i> Approve </button> <button type="button" class="btn btn-primary btn-dis-approve" disabled=""> <i class="fa fa-close"></i> DisApprove </button> <button type="button" id="checkAll" class="main btn btn-primary btn-check"> <span class="sub"></span> <i class="fa fa-check"></i> Check </button> <button type="button" id="uncheckAll" class="main btn btn-primary btn-uncheck"> <span class="sub"></span> <i class="fa fa-check"></i> UnCheck </button>

                      </div>

                    </div>

                    <?php } ?>

  <table class="table table-striped table-bordered new-table" id="table">   



<?php if ($type == "new") { ?>

                                    <thead>

                                       <tr>

                                          <th>Check</th>

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



                                <?php } elseif ($type == "can") { ?>

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

                                <?php } else { ?>



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

           $thischeckaction =

               '<input type="checkbox" class="wtid" name="wtid[]" id="wtid' .

               $wtid .

               '" data-id=' .

               $key .

               " data-uid=" .

               $thisuid .

               " data-withdrawal=" .

               $withdrawal .

               ' value="' .

               $wtid .

               '"/>';

       } elseif ($isapprove == 1) {

           $thisstatus =

               '<strong style="color:#089000!important;">Approved</strong>';

           $thischeckaction = "";

       } elseif ($isapprove == 0) {

           $thisstatus =

               '<strong style="color:#DB4473!important;">Cancelled</strong>';

           $thischeckaction = "";

       }

       $thisdetails = $thiswhref;



       if ($type == "new") {

           $paginationHtml .= "<tr>";

           $paginationHtml .= "<td>" . $thischeckaction . "</td>";

           $paginationHtml .= "<td>" . $thisdetails . "</td>";

           $paginationHtml .= "<td>" . $thisphone . "</td>";

           $paginationHtml .= "<td>" . $thisemail . "</td>";

           $paginationHtml .= "<td>" . $thisrefcode . "</td>";

           $paginationHtml .= "<td>" . $thistxid . "</td>";

           $paginationHtml .= "<td>" . $thismethod . "</td>";

           $paginationHtml .= "<td>" . $thiswithdrawal . "</td>";

           $paginationHtml .= "<td>" . $thisstatus . "</td>";

           $paginationHtml .= "</tr>";

       } elseif ($type == "can") {

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

       } else {

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

            '<div class="row"></div><div class="col-sm-12"><strong>There is no withdrawal found of ' .

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

