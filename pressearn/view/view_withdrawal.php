<?php

// view withdrawal //



// include conn //

include_once "../conn/conn.php";

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

$trefcode = "";

$withdrawal = "";

$isapprove = "";

$thisddate = "";

$thistrefcode = "";

$thisdnlv = "";

$thiswithdrawalby = "";

$thisstatus = "";

$thismsglabel = "";

$thisheading = "";

$thisdate = "";

$target = "";

$thisimg = "";

$activeclass = "";

$defaultclass = "";

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



if (isset($_POST["uid"])) {

    $uid = $_POST["uid"];

}

if (($type == "with" && $search == "") || $search != "") {

    $all_qry =

        "SELECT users.uname as uname,withdrawal.* from withdrawal INNER JOIN users on users.userid = withdrawal.uid where withdrawal.iswithdrawal = 1 and withdrawal.isapprove = 1 and withdrawal.uid = '" .

        $uid .

        "' order by withdrawal.wtid desc";

    $thismsglabel = "There is no withdrawal found";

    $thisheading = "Withdrawal";

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

            $activeclass = 'style="background-color: #fff;border-color: #ccc;"';

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

$tsum = (int) $total;

$trsum = (int) $totalRecords;



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

                                          <th>Withdrawal Date</th>

                                          <th>Withdrawal</th>

                                          <th>Status</th>

                                       </tr>

                                    </thead>

<?php

}

?>

<tbody>

<?php

if (($type == "with" && $search == "") || $search != "") {

    $all_qry =

        "SELECT users.uname as uname,withdrawal.* from withdrawal INNER JOIN users on users.userid = withdrawal.uid where withdrawal.iswithdrawal = 1 and withdrawal.uid = '" .

        $uid .

        "' order by withdrawal.wtid desc $limit";

    $thismsglabel = "There is no withdrawal found";

    $thisheading = "Withdrawal";

}



mysqli_query($conn, "set character_set_results='utf8'");

$res = mysqli_query($conn, $all_qry);

$sql = $res;

if (mysqli_num_rows($sql)) { ?>  



   <?php foreach ($sql as $key => $row) {

       $key++;

       $uid = $row["uid"];

       $wtid = $row["wtid"];

       $ddate = $row["withdrawaldate"];

       $withdrawal = $row["withdrawal"];

       $trefcode = $row["refcode"];

       $downlinelv = $row["downlinelv"];

       $withdrawalby = $row["uname"];

       $isapprove = $row["isapprove"];

       $status = $row["status"];

       $thiswithdrawal = $withdrawal;

       $thiswithdrawalby = $withdrawalby;

       $thisddate = $ddate;

       $thisdate = date_create($thisddate);

       $thisdate = date_format($thisdate, "d-m-Y");

       $thiswithdrawal = '$' . $withdrawal;

       empty($trefcode) ? ($thistrefcode = "") : ($thistrefcode = $trefcode);



       if ($isapprove == 0) {

           $thisstatus =

               '<strong style="color:#4285F4!important;">Pending</strong>';

       }

       if ($isapprove == 1) {

           $thisstatus =

               '<strong style="color:#089000!important;">Approved</strong>';

       }



       $paginationHtml .= "<tr>";

       $paginationHtml .= "<td>" . $thiswithdrawalby . "</td>";

       // $paginationHtml .= "<td>" . $thistrefcode . "</td>";

       $paginationHtml .= "<td>" . $thisdate . "</td>";

       $paginationHtml .= "<td>" . $thiswithdrawal . "</td>";

       $paginationHtml .= "<td>" . $thisstatus . "</td>";

       $paginationHtml .= "</tr>";

   }} else {if ($search != "") {

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

    $paginationCtrls = "";}

echo $paginationHtml;

?>

</tbody>

</table>

 <div id="pagination" class="pagination"><?php echo $paginationCtrls; ?></div>

 </div>

