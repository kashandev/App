<?php
// include session //
include_once ('../session/session.php'); // this is used for include session //
// end of include session //
// include conn //
include_once ('../../conn/conn.php'); // this is used for include conn //
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
$all_qry = '';
$result = '';
$where = '';
$and_like = '';
$sql = '';
$limit = '';
$next = '';
$previous = '';
$paginationHtml = '';
$search = '';
$type = '';
$thislabel = '';
$paginationCtrls = '';
$thisrefcode = '';
$thisname = '';
$thisemail = '';
$thiscountry = '';
$thisccode = '';
$thismobile = '';
$thisstatus = '';
$thishref = '';
$thismsglabel = '';
$thisheading = '';
$thisnow  = '';
$thisnext = '';
$thisdate = '';
$thismovedate = '';
// end of variables //
if (isset($_POST['page']))
{
    $page = $_POST['page'];
}

if (isset($_POST['type']))
{
    $type = $_POST['type'];
}

if (isset($_POST['search']))
{
    $search = $_POST['search'];
}


if ($type == 'all' && $search == '' || $search != '')
{
    $all_qry = "SELECT * from supporters order by supid desc";
    $thismsglabel = 'There is no all supporters found';
    $thisheading = 'Total Signup';

}

if ($type == 'new' && $search == '' || $search != '')
{
    $all_qry = "SELECT * from supporters where status = '" . $type . "' and isnew = 1 order by supid desc";
    $thismsglabel = 'There is no new supporters found';
    $thisheading = 'New Signup';
}


mysqli_query ($conn ,"set character_set_results='utf8'");
$res = mysqli_query($conn, $all_qry);
$totalRecords = mysqli_num_rows($res);
$totalPages = ceil($totalRecords / $perPage);
if ($totalPages < 1)
{
    $totalPages = 1;
}
$pagenum = 1;

if ($pagenum < 1)
{
    $pagenum = 1;
}
else if ($pagenum > $totalPages)
{
    $pagenum = $totalPages;
}

if ($page == '')
{
    $startFrom = ($pagenum - 1) * $perPage;
}
else
{
    $startFrom = ($page - 1) * $perPage;
}

$paginationCtrls = '';

if ($totalPages != 1)
{

    if ($pagenum > 1 && $page == '')
    {
        $previous = $pagenum - 1;
        $paginationCtrls .= '<a data-page="' . $previous . '" class="btn btn-default btn-page">Previous</a> &nbsp;';
    }
    if ($page > 1 && $page != '')
    {
        $previous = $page - 1;
        $paginationCtrls .= '<a data-page="' . $previous . '" class="btn btn-default btn-page">Previous</a> &nbsp;';
    }
    for ($i = $pagenum - 4;$i < $pagenum;$i++)
    {

    }

    $paginationCtrls .= '<a data-page="' . $pagenum . '" class="btn btn-default btn-page">' . $i . '</a> &nbsp;';
    for ($i = $pagenum + 1;$i <= $totalPages;$i++)
    {
        $paginationCtrls .= '<a data-page="' . $i . '" class="btn btn-default btn-page">' . $i . '</a> &nbsp; ';
    }
    if ($page == '' && $pagenum != $totalPages)
    {
        $next = $pagenum + 1;
        $style = 'style="pointer-events:default; cursor:pointer;"';
    }
    if ($page != '' && $page != $totalPages)
    {
        $next = $page + 1;
        $style = 'style="pointer-events:default; cursor:pointer;"';
    }
    if ($page == $totalPages)
    {
        $style = 'style="pointer-events:none; cursor:default;"';
    }
    $paginationCtrls .= ' &nbsp; &nbsp; <a data-page="' . $next . '" class="btn btn-default btn-next" ' . $style . '>Next</a> ';
}

$limit = "limit $startFrom,$perPage ";

if ($type == 'all' && $search == '' || $search != '')
{
    $all_qry = "SELECT * from supporters $limit";
    $thismsglabel = 'There is no all supporters found';
    $thisheading = 'Total Signup';

}
if ($type == 'new' && $search == '' || $search != '')
{
    $all_qry = "SELECT * from supporters where status = '" . $type . "' and isnew = 1 order by supid desc $limit ";
    $thismsglabel = 'There is no new supporters found';
    $thisheading = 'New Signup';
}
$res = mysqli_query($conn, $all_qry);
$sql = $res;
$total = mysqli_num_rows($sql);
if (mysqli_num_rows($sql))
{
    $thislabel = '<strong class="result"> Showing ' . $total . ' of ' . $totalRecords . ' entries </strong>';
?>
           <?php echo $thislabel ?>
                                  <div class="row">
                                  <div class="col-sm-12">
                                    <h2 style="text-align: center;"><strong><?php echo $thisheading ?></strong></h2>
                                  </div>
                                 </div>
                        <table class="table table-striped table-bordered supporters-table" id="table">   
                                    <thead>
                                       <tr>
                                         <th>SNo</th>
                                          <th>Supporter Name</th>
                                          <th>Ref Code</th>
                                          <th>Email</th>
                                          <th>Mobile No</th>
                                          <th>Country</th>
                                          <th>Status</th>


                                       </tr>
                                    </thead>
                                    <tbody>
       
   
   <?php
    foreach ($sql as $key => $row)
    {
        $key++;
        $supid = $row['supid'];
        $refcode = $row['refcode'];
        $sname = $row['sname'];
        $email = $row['email'];
        $mobile = $row['mobile'];
        $country = $row['country'];
        $ccode = $row['ccode'];
        $status = $row['status'];
        $createdate = $row['createdate'];
        $thisrefcode = $refcode;
        $thisname = $sname;
        $thisccode = $ccode;
        $thismobile = $mobile;
        $thiscountry = $country;
        $thisstatus = '<strong style="color:#4285F4!important;">'.ucfirst($status).'</strong>';
        empty($email) ? $thisemail = 'null' : $thisemail = $email;

        // $thisdate = date_create($createdate);
        // $thisdate = date_format($thisdate,'d-m-Y');
        // $thisnow = date('d-m-Y');
        // $thisnext =date('d-m-Y', strtotime($thisdate. '+2 days'));
        // $thismovedate = date('Y-m-d', strtotime($thisdate. '+2 days'));
        // if($thisnow == $thisnext)
        // {
        //    $sql = "UPDATE `supporters` SET isnew = 0 , movetoold = '".$thismovedate."' where supid = '".$supid."' and isnew = 1";
        //    $res = mysqli_query($conn, $sql);
        // }
        
         $thishref = '<a href="">' . $thisname . '</a>';

        $paginationHtml .= '<tr>';
        $paginationHtml .= '<td>' . $key . '</td>';
        $paginationHtml .= '<td>' . $thishref . '</td>';
        $paginationHtml .= '<td>' . $thisrefcode . '</td>';
        $paginationHtml .= '<td>' . $thisemail . '</td>';
        $paginationHtml .= '<td>' . $thismobile . '</td>';
        $paginationHtml .= '<td>' . $thiscountry . '</td>';
        $paginationHtml .= '<td>' . $thisstatus . '</td>';
        $paginationHtml .= '</tr>';
    }
}
else
{
    if ($search != '')
    {
        $paginationHtml = '<div class="row"></div><div class="col-sm-12"><strong>There is no supporters found of ' . $search . '</strong></div>';
    }
    else
    {
        $paginationHtml = '<div class="row"></div><div class="col-sm-12"><strong>' . $thismsglabel . '</strong></div>';
    }
    $paginationCtrls = '';
}
echo $paginationHtml;
?>
</tbody>
</table>
 <div id="pagination" class="pagination"><?php echo $paginationCtrls; ?></div>
 </div>
