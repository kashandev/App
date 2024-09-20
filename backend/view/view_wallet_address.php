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
$waid = "";
$cid = "";
$company = "";
$wadd = "";
$isdeleted = "";
$isedit = "";
$isrestore = "";
$isactive = "";
$thisname = "";
$thiswadd = "";
$thiscompany = "";
$thisstatus = "";
$thishref = "";
$thismsglabel = "";
$thisheading = "";
$thisnow = "";
$thisnext = "";
$thischeckaction = "";
$thisaction = "";
$thisactive = "";
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

if ($type == "all" && $search == "" || $search != "") {
    $all_qry =
        "SELECT wallet_address.*,company.company from wallet_address inner join company on company.cid = wallet_address.cid where wallet_address.isdeleted = 0 order by wallet_address.waid desc";
    $thismsglabel = "There is no wallet address found";
    $thisheading = "All";
}
if ($type == "del" && $search == "" || $search != "") {
    $all_qry =
        "SELECT wallet_address.*,company.company from wallet_address inner join company on company.cid = wallet_address.cid where wallet_address.isdeleted = 1 order by wallet_address.waid desc";
    $thismsglabel = "There is no deleted wallet address found";
    $thisheading = "Deleted";
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

if ($type == "all" && $search == "" || $search != "") {
    $all_qry = "SELECT wallet_address.*,company.company from wallet_address inner join company on company.cid = wallet_address.cid where wallet_address.isdeleted = 0 order by wallet_address.waid desc $limit";
    $thismsglabel = "There is no wallet address found";
    $thisheading = "All";
}

if ($type == "del" && $search == "" || $search != "") {
    $all_qry = "SELECT wallet_address.*,company.company from wallet_address inner join company on company.cid = wallet_address.cid where wallet_address.isdeleted = 1 order by wallet_address.waid desc $limit";
    $thismsglabel = "There is no deleted wallet address found";
    $thisheading = "Deleted";
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
<?php if ($type == "all") { ?>

                         <div class="row" id="button-div">  
                        <div class="col-sm-8"><button type="button" class="btn btn-primary btn-delete" disabled=""><i class="fa fa-trash"> </i>  Delete </button> <button type="button" id="checkAll" class="main btn btn-primary btn-check"> <span class="sub"></span> <i class="fa fa-check"> </i> Check </button> <button type="button" id="uncheckAll" class="main btn btn-primary btn-uncheck"> <span class="sub"></span> <i class="fa fa-check"> </i> UnCheck </button>
                      </div>
                    </div>
                    
                    <?php } elseif ($type == "del") { ?>


                         <div class="row" id="button-div">  
                        <div class="col-sm-8"> <button type="button" class="btn btn-primary btn-restore" disabled=""> <i class="fa fa-undo"> </i> Restore </button> <button type="button" id="checkAll" class="main btn btn-primary btn-check-r"> <span class="sub"></span> <i class="fa fa-check"> </i> Check </button> <button type="button" id="uncheckAll" class="main btn btn-primary btn-uncheck-r"> <span class="sub"></span> <i class="fa fa-check"> </i> UnCheck </button>
                      </div>
                    </div>
                    
                    <?php } ?>

  <table class="table table-striped table-bordered table" id="table">                    
<?php if ($type == "all") { ?>
                                    <thead>
                                       <tr>
                                          <th>Check</th>
                                          <th>Name</th>
                                          <th>Company</th>
                                          <th>Wallet Address</th>
                                          <th>Active</th>
                                          <th>Status</th>
                                          <th>Action</th> 
                                       </tr>
                                    </thead>

                                <?php } elseif ($type == "del") { ?>
                                    <thead>
                                       <tr>
                                          <th>Check</th>
                                          <th>Name</th>
                                          <th>Company</th>
                                          <th>Wallet Address</th>
                                          <th>Active</th>
                                          <th>Status</th>
                                       </tr>
                                    </thead>
                                <?php } ?>
    
                              
    <tbody>
   <?php foreach ($sql as $key => $row) {
       $key++;
       $waid = $row["waid"];
       $cid = $row["cid"];
       $company = $row["company"];
       $name = $row["name"];
       $wadd = $row["waddress"];
       $isactive = $row["isactive"];
       $isdeleted = $row["isdeleted"];
       $isrestore = $row["isrestore"];
       $isedit = $row["isedit"];
       $status = $row["status"];
       $thisname = $name;
       $thiswadd = $wadd;
       $thiscompany = $company;

       if ($isactive == 1) {
           $thisactive = "yes";
       } else {
           $thisactive = "no";
       }
       if ($isdeleted == 0) {
           $thisstatus =
               '<strong style="color:#4285F4!important;">New</strong>';
           $thischeckaction =
               '<input type="checkbox" class="waid" name="waid[]" id="waid' .
               $waid .
               '" data-id=' .
               $key .
               ' value="' .
               $waid .
               '"/>';
           $thisaction =
               '<span style="color:#089000!important; cursor:pointer;" class="btn-search" data-id="' .
               $waid .
               '"> Update <i class="fa fa-pencil"></i></span>';
       }
       if ($isdeleted == 1) {
           $thisstatus =
               '<strong style="color:#DB4473!important;">Deleted</strong>';
           $thischeckaction =
               '<input type="checkbox" class="dwaid" name="dwaid[]" id="dwaid' .
               $waid .
               '" data-id=' .
               $key .
               ' value="' .
               $waid .
               '"/>';
       }
       if ($isedit == 1) {
           $thisstatus =
               '<strong style="color:#089000!important;">Updated</strong>';
       }
       if ($isrestore == 1) {
           $thisstatus =
               '<strong style="color:#089000!important;">Restored</strong>';
       }

       if ($type == "all") {
           $paginationHtml .= "<tr>";
           $paginationHtml .= "<td>" . $thischeckaction . "</td>";
           $paginationHtml .= "<td>" . $thisname . "</td>";
           $paginationHtml .= "<td>" . $thiscompany . "</td>";
           $paginationHtml .= "<td>" . $thiswadd . "</td>";
           $paginationHtml .= "<td>" . $thisactive . "</td>";
           $paginationHtml .= "<td>" . $thisstatus . "</td>";
           $paginationHtml .= "<td>" . $thisaction . "</td>";
           $paginationHtml .= "</tr>";
       } elseif ($type == "del") {
           $paginationHtml .= "<tr>";
           $paginationHtml .= "<td>" . $thischeckaction . "</td>";
           $paginationHtml .= "<td>" . $thisname . "</td>";
           $paginationHtml .= "<td>" . $thiscompany . "</td>";
           $paginationHtml .= "<td>" . $thiswadd . "</td>";
           $paginationHtml .= "<td>" . $thisactive . "</td>";
           $paginationHtml .= "<td>" . $thisstatus . "</td>";
           $paginationHtml .= "</tr>";
       }
   }
} else {
    if ($search != "") {
        $paginationHtml =
            '<div class="row"></div><div class="col-sm-12"><strong>There is no wallet address found of ' .
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
