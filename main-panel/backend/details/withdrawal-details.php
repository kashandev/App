<?php
// include session //
include_once ('../session/session.php'); // this is used for include session //
// end of include session //
// include date //
include_once "../date/date.php"; // this is used for include date//
// end of include date //

// include conn //
include_once ('../../conn/conn.php'); // this is used for include conn //
// end of include conn //
?>
<!-- title -->
<title>Withdrawal Details</title>
<!-- /.title -->
<?php
// include details links //
include_once('../links/details-links.php'); // this is used for include details links //
// end of include details links //
?>
<?php
// variables //

$key = 0;
$all_qry = '';
$result = '';
$where = '';
$and_like = '';
$sql = '';
$limit = '';
$userHtml = '';
$withdrawalHtml = '';
$search = '';
$detail = '';
$thislabel = '';
$thisrefcode = '';
$thismethod ='';
$thistxid = '';
$thidate = '';
$thiswithdrawal = '';
$thisrealname = '';
$thisemail = '';
$thisphone = '';
$thisstatus = '';
$thishref = '';
$thisdhref = '';
$thisdetails = '';
$thismsglabel = '';
$thisheading = '';
$thisaction = '';  
// end of variables //

if (isset($_GET['detail']) == '')
{
    $_GET['detail'] = '';
}
if (isset($_GET['detail']))
{
    $detail = $_GET['detail'];
}

if ($detail != '')
{
    $all_qry = "SELECT withdrawal.*,topup_method.tpmethod from withdrawal INNER JOIN topup_method on topup_method.tpmid = withdrawal.tpmid where withdrawal.wtid = '".$detail."'  order by withdrawal.wtid desc";
    $thisheading = 'Withdrawal Details';

}

mysqli_query ($conn ,"set character_set_results='utf8'");
$res = mysqli_query($conn, $all_qry);
$sql = $res;
$total = mysqli_num_rows($sql);
if (mysqli_num_rows($sql))
{

?>
<div class="container">
<div class="printThis" id="printThis">

                                  <div class="row">
                                  <div class="col-sm-12">
                                  <img src="../public/images/logo/logo_79x80.png" class="img" alt="Logo" title="Logo">
                                  </div>
                                </div>
                                  <div class="row">
                                 <div class="col-sm-12">
                                  <h2 class="head-label"><strong><?php echo $thisheading ?></strong></h2>
                                 </div>
                               </div>
                                <div class="row">
                                  <div class="col-sm-12">
                                  <label class="print-label"><label><strong>Print Date : <?php echo $printdate ?></strong></label></h2>
                                  </div>
                                </div>      

  <div class="row">
  <div class="col-sm-12">                         
  <table class="table table-striped table-bordered new-table" id="table" border="2">                    
                    <thead>
                                       <tr>
                                          <th>Real Name</th>
                                          <th>Email</th>
                                          <th>Phone</th>
                                       </tr>
                                     </thead>



<tbody>
   <?php
    foreach ($sql as $key => $row)
    {
        $key++;
        $realname = $row['realname'];
        $email = $row['email'];
        $phone = $row['phone'];
        $thisrealname = $realname;
        empty($email) ? $thisemail = '----------------------' : $thisemail = $email;
        $thisphone = $phone;
        $userHtml .= '<tr>';
        $userHtml .= '<td>' . $thisrealname . '</td>';
        $userHtml .= '<td>' . $thisemail . '</td>';
        $userHtml .= '<td>' . $thisphone . '</td>';
        $userHtml .= '</tr>';
     
 }
echo $userHtml;
?>
</tbody>
  </table>
   </div>
 </div>

<br>
  <div class="row">
  <div class="col-sm-12">                           
  <table class="table table-striped table-bordered new-table" id="table" border="2">                    
                    <thead>
                                       <tr>
                                          <th>Transaction ID</th>
                                          <th>Date</th>
                                          <th>Withdrawal</th>
                                          <th>Status</th>
                                       </tr>
                                    </thead>



<tbody>
   <?php
    foreach ($sql as $key => $row)
    {
        $key++;
        $tpmethod = $row['tpmethod'];
        $withdrawal = $row['withdrawal'];
        $txid = $row['txid'];
        $isnew = $row['isnew'];
        $isapprove = $row['isapprove'];
        $status = $row['status'];
        $withdrawaldate = $row['withdrawaldate'];
        $thisdate = date_create($withdrawaldate);
        $thisdate = date_format($thisdate,'D,d M Y');
        $thistxid = $txid;
        $thismethod = str_replace($tpmethod,'','USDT');
        $thiswithdrawal = $withdrawal.'-'.$thismethod;
        if($isapprove == 0){
         $thisstatus = '<strong style="color:#DB4473!important;">Pending</strong>'; 
        }
        if($isapprove == 1){
         $thisstatus = '<strong style="color:#089000!important;">Completed</strong>'; 
        }
        if($isapprove == 0 && $isnew == 0){
         $thisstatus = '<strong style="color:#DB4473!important;">Cancelled</strong>'; 
        }

        $withdrawalHtml .= '<tr>';
        $withdrawalHtml .= '<td>' . $thistxid . '</td>'; 
        $withdrawalHtml .= '<td>' . $thisdate . '</td>'; 
        $withdrawalHtml .= '<td>' . $thiswithdrawal . '</td>';
        $withdrawalHtml .= '<td>' . $thisstatus . '</td>';
        $withdrawalHtml .= '</tr>';
     
 }
}
else
{
    if ($search != '')
    {
        $$withdrawalHtml = '<div class="row"></div><div class="col-sm-12"><strong>There is no Withdrawal found of ' . $search . '</strong></div>';
    }
    else
    {
        $thismsglabel = 'There is no withdrawal details found';
        $$withdrawalHtml = '<div class="row"></div><div class="col-sm-12"><strong>' . $thismsglabel . '</strong></div>';
    }
}
echo $withdrawalHtml;
?>
</tbody>
  </table>
   </div>
 </div>
</div>
  <div class="row">
  <div class="col-sm-6">  
 <div id="pagination" class="pagination"><button type="button" class="btn btn-primary btn-print" id="printbtn"><i class="fa fa-print"></i> Print </button> <button type="button" class="btn btn-primary" onclick=window.location.href="../withdrawal.php"> <i class="fa fa-arrow-left"></i> Back </button></div>
</div>
</div>
</div>

<script type="text/javascript">
// start jquery //
$(document).ready(function(){
  
  //  prin function //
   
   $('.btn-print').click(function(){
    $('button').hide();
    window.print();
    $('button').show();
   });
  // end of print function //
});
// end of jquery //
</script>