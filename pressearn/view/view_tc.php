<?php
// view team commission //
// include session //
include_once ('../session/session.php'); // this is used for include session //
// end of include session //
// include conn //
include_once ('../conn/conn.php'); // this is used for include conn //
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
$thisdepositby = '';
$thismethod ='';
$thisdeposit = '';
$thisattachment = '';
$thisstatus = '';
$thishref = '';
$thismsglabel = '';
$thisheading = '';
$thisnow  = '';
$thisnext = '';
$thisdate = '';
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

    $all_qry = "SELECT users.uname,users.refcode,topup_method.tpmethod as tpm,(SELECT deposite.txid from deposite WHERE deposite.uid = users.userid and deposite.isdeposit = 1) as txid,(SELECT deposite.deposit from deposite WHERE deposite.uid = users.userid and deposite.isdeposit = 1) as dept,(SELECT withdrawal.withdrawal from withdrawal WHERE withdrawal.uid = users.userid and withdrawal.iswithdrawal = 1) as withd ,(SELECT team_commission.commission from team_commission WHERE team_commission.refcode = users.refcode) as tcom from users INNER JOIN deposite on deposite.uid = users.userid INNER JOIN withdrawal on withdrawal.uid = users.userid INNER JOIN topup_method on topup_method.tpmid = deposite.tpmid WHERE users.userid = 41";
    $thismsglabel = 'There is no all details found';
    $thisheading = 'All';
}

// if ($type == 'all' && $search != '')
// {
//     $all_qry = "SELECT * from deposite where deposite.isapproved = 1 where deposite.uname = '" . $search . "' and deposite.isdeleted = 0 and roles.role not in('cp admin') ";

// }
// if ($type == 'dep' && $search != '')
// {
//     $all_qry = "SELECT deposite.*,roles.* from deposite inner join roles on roles.roleid = deposite.roleid where deposite.status = '" . $type . "' and deposite.uname = '" . $search . "' and deposite.isdeleted =0 and deposite.isall = 1 and roles.role not in('cp admin') ";
// }

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
        if ($i >= $pagenum + 4)
        {
            break;
        }
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

    $all_qry = "SELECT users.uname,users.refcode,topup_method.tpmethod as tpm,(SELECT deposite.txid from deposite WHERE deposite.uid = users.userid and deposite.isdeposit = 1) as txid,(SELECT deposite.deposit from deposite WHERE deposite.uid = users.userid and deposite.isdeposit = 1) as dept,(SELECT withdrawal.withdrawal from withdrawal WHERE withdrawal.uid = users.userid and withdrawal.iswithdrawal = 1) as withd ,(SELECT team_commission.commission from team_commission WHERE team_commission.refcode = users.refcode) as tcom from users INNER JOIN deposite on deposite.uid = users.userid INNER JOIN withdrawal on withdrawal.uid = users.userid INNER JOIN topup_method on topup_method.tpmid = deposite.tpmid WHERE users.userid = 41 $limit";
    $thismsglabel = 'There is no all details found';
    $thisheading = 'All';

}


mysqli_query ($conn ,"set character_set_results='utf8'");
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
<?php
if ($type == 'all'){
?>

                         <div class="row" id="button-div">  
                        <div class="col-sm-8"><button type="button" class="btn btn-primary btn-approve" disabled=""> Approve </button> <button type="button" id="checkAll" class="main btn btn-primary btn-check"> <span class="sub"></span> Check </button> <button type="button" id="uncheckAll" class="main btn btn-primary btn-uncheck"> <span class="sub"></span> UnCheck </button>
                      </div>
                    </div>
                    
                    <?php } ?>
  <table class="table table-striped table-bordered all-table" id="table">                    
                                    <thead>
                                       <tr>
                                          <th>User</th>
                                          <th>Ref Code</th>
                                          <th>Method</th>
                                          <th>Deposit</th>
                                          <th>Withdrawal</th>
                                          <th>Commission</th>
                                          <th>Status</th>
                                       </tr>
                                    </thead>

                                
    <tbody>
   <?php
//     foreach ($sql as $key => $row)
//     {
//         $key++;
//         $uid = $row['uid'];
//         $dpid = $row['dpid'];
//         $refcode = $row['refcode'];
//         $depositby = $row['depositby'];
//         $tpmethod = $row['tpmethod'];
//         $deposit = $row['deposit'];
//         $txcrtf = $row['txcrtf'];
//         $isall  = $row['isall'];
//         $isapprove = $row['isapprove'];
//         $status = $row['status'];
//         $depositdate = $row['depositdate'];
//         $thisrefcode = $refcode;
//         $thisdepositby = $depositby;
//         $thismethod = $tpmethod;
//         $thisdeposit = $deposit;
//         empty($txcrtf) ? $thisattachment = 'null' : $thisattachment = $txcrtf;
//         $thisattachment == 'null' ? $thishref = '': $thishref = 'public/images/deposit/'.$txcrtf;
        
//         if($isall == 1)
//          {
//           $thisstatus = '<strong style="color:#4285F4!important;">'.ucfirst('all').'</strong>';    
//           $thischeckaction = '<input type="checkbox" class="dpid" name="dpid[]" id="dpid'.$dpid.'" data-id='.$key.' value="'.$dpid.'"/>';
//          }
        
//         if($isapprove == 1){
//          $thisstatus = '<strong style="color:#089000!important;">'.ucfirst('Deposit').'</strong>'; 
//          $thischeckaction = '';   
//         }
        
//          $thishref = '<a href="'.$thishref.'">' . $thisattachment . '</a>';

//     if($type == 'all')
//          {
    

//         $paginationHtml .= '<tr>';
//         $paginationHtml .= '<td>' . $thischeckaction . '</td>';
//         $paginationHtml .= '<td>' . $thisdepositby . '</td>';
//         $paginationHtml .= '<td>' . $thisrefcode . '</td>';
//         $paginationHtml .= '<td>' . $thismethod . '</td>';
//         $paginationHtml .= '<td>' . $thisdeposit . '</td>';
//         $paginationHtml .= '<td>' . $thishref . '</td>';
//         $paginationHtml .= '<td>' . $thisstatus . '</td>';
//         $paginationHtml .= '</tr>';
//     }
//     else
//     {
        
//         $paginationHtml .= '<tr>';
//         $paginationHtml .= '<td>' . $thisdepositby . '</td>';
//         $paginationHtml .= '<td>' . $thisrefcode . '</td>';
//         $paginationHtml .= '<td>' . $thismethod . '</td>';
//         $paginationHtml .= '<td>' . $thisdeposit . '</td>';
//         $paginationHtml .= '<td>' . $thishref . '</td>';
//         $paginationHtml .= '<td>' . $thisstatus . '</td>';
//         $paginationHtml .= '</tr>';
//     }
            
//  }
// }
// else
// {
//     if ($search != '')
//     {
//         $paginationHtml = '<div class="row"></div><div class="col-sm-12"><strong>There is no all details found of ' . $search . '</strong></div>';
//     }
//     else
//     {
//         $paginationHtml = '<div class="row"></div><div class="col-sm-12"><strong>' . $thismsglabel . '</strong></div>';
//     }
//     $paginationCtrls = '';
}
//echo $paginationHtml;
?>
</tbody>
</table>
 <div id="pagination" class="pagination"><?php echo $paginationCtrls; ?></div>
 </div>
