<?php

// view orders //

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

$Pre = '';

$paginationHtml = '';

$search = '';

$type = '';

$uid ='';

$thislabel = '';

$paginationCtrls = '';

$odate = "";

$otime = "";

$ono = "";

$pname = "";

$pimg = "";

$amount = "";

$iscomplete = "";

$iscancel = "";

$thisono = "";

$thisodate = "";

$thisotime = "";

$thisodatetime = "";

$thispname = "";

$thispimg = "";

$thisamount = "";

$thisorderby = '';

$thisstatus = '';

$thismsglabel = '';

$thisheading = '';

$thisdate = '';

$target = "";

$thisimg = "";

$activeclass = "";

$defaultclass = "";

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





if (isset($_POST['uid']))

{

    $uid = $_POST['uid'];

}



if ($type == 'all' && $search == '' || $search != '')

{



    $all_qry = "SELECT users.uname as orderby,orders.*,product_images.pname,product_images.pimg from orders INNER JOIN product_images on product_images.oid = orders.oid INNER JOIN users on users.userid = orders.uid where orders.uid = '".$uid."' order by orders.oid desc";

    $thismsglabel = 'There is no orders found';

    $thisheading = 'All Orders';

}



if ($type == 'pend' && $search == '' || $search != '')

{

    $all_qry = "SELECT users.uname as orderby,orders.*,product_images.pname,product_images.pimg from orders INNER JOIN product_images on product_images.oid = orders.oid INNER JOIN users on users.userid = orders.uid where orders.iscancel = 0 and orders.iscomplete = 0 and orders.uid = '".$uid."' order by orders.oid desc";

    $thismsglabel = 'There is no pending orders found';

    $thisheading = 'Pending Orders';

}

if ($type == 'comp' && $search == '' || $search != '')

{

   $all_qry = "SELECT users.uname as orderby,orders.*,product_images.pname,product_images.pimg from orders INNER JOIN product_images on product_images.oid = orders.oid INNER JOIN users on users.userid = orders.uid where orders.iscancel = 0 and orders.iscomplete = 1 and orders.uid = '".$uid."'  order by orders.oid desc";

   $thismsglabel = 'There is no completed orders found';

   $thisheading = 'Completed Orders';

}



if ($type == 'can' && $search == '' || $search != '')

{

   $all_qry = "SELECT users.uname as orderby,orders.*,product_images.pname,product_images.pimg from orders INNER JOIN product_images on product_images.oid = orders.oid INNER JOIN users on users.userid = orders.uid where orders.iscancel = 1 and orders.iscomplete = 0 and orders.uid = '".$uid."'  order by orders.oid desc";

   $thismsglabel = 'There is no cancelled orders found';

   $thisheading = 'Cancelled Orders';

}



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

        $Pre = $pagenum - 1;

        $paginationCtrls .= '<a data-page="' . $Pre . '" class="btn btn-default btn-page">Pre</a> &nbsp;';

    }

    if ($page > 1 && $page != '')

    {

        $Pre = $page - 1;

        $paginationCtrls .= '<a data-page="' . $Pre . '" class="btn btn-default btn-page">Pre</a> &nbsp;';

    }

    for ($i = 1;$i <= $totalPages;$i++)

    {



      if($page == '' && $i == 1)

      {

        $defaultclass = 'style="background-color: #110863 !important;color: #fffd;"';

      }else

      {

        $defaultclass = '';

      }

       if($page == $i){

        $activeclass = 'style="background-color: #110863 !important;color: #fffd;"';

       }else{

        $activeclass = 'style="background-color: #fff;border-color: #ccc;"';

       }

        $paginationCtrls .= '<a data-page="' . $i . '" class="btn btn-default btn-page" '.$defaultclass.' '.$activeclass.' >' . $i . '</a> &nbsp; ';

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



    $all_qry = "SELECT users.uname as orderby,orders.*,product_images.pname,product_images.pimg from orders INNER JOIN product_images on product_images.oid = orders.oid INNER JOIN users on users.userid = orders.uid where orders.uid = '".$uid."'  order by orders.oid desc $limit ";

    $thismsglabel = 'There is no orders found';

    $thisheading = 'All Orders';

}



if ($type == 'pend' && $search == '' || $search != '')

{

    $all_qry = "SELECT users.uname as orderby,orders.*,product_images.pname,product_images.pimg from orders INNER JOIN product_images on product_images.oid = orders.oid INNER JOIN users on users.userid = orders.uid where orders.iscancel = 0 and orders.iscomplete = 0 and orders.uid = '".$uid."'  order by orders.oid desc $limit";

    $thismsglabel = 'There is no pending orders found';

    $thisheading = 'Pending Orders';

}

if ($type == 'comp' && $search == '' || $search != '')

{

   $all_qry = "SELECT users.uname as orderby,orders.*,product_images.pname,product_images.pimg from orders INNER JOIN product_images on product_images.oid = orders.oid INNER JOIN users on users.userid = orders.uid where orders.iscancel = 0 and orders.iscomplete = 1 and orders.uid = '".$uid."'  order by orders.oid desc $limit";

   $thismsglabel = 'There is no completed orders found';

   $thisheading = 'Completed Orders';

}



if ($type == 'can' && $search == '' || $search != '')

{

   $all_qry = "SELECT users.uname as orderby,orders.*,product_images.pname,product_images.pimg from orders INNER JOIN product_images on product_images.oid = orders.oid INNER JOIN users on users.userid = orders.uid where orders.iscancel = 1 and orders.iscomplete = 0 and orders.uid = '".$uid."'  order by orders.oid desc $limit";

   $thismsglabel = 'There is no cancelled orders found';

   $thisheading = 'Cancelled Orders';



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



  <table class="table table-striped table-bordered all-table" id="table">                    

                                    <thead>

                                       <tr>

                                          <th>Order By</th>

                                          <th>Order Date</th>

                                          <th>Order No</th>

                                          <th>Image</th>

                                          <th>Product</th>

                                          <th>Amount</th>

                                          <th>Status</th>

                                       </tr>

                                    </thead>

                                

    <tbody>

   <?php



    foreach ($sql as $key => $row)

    {

        $key++;

        $uid = $row['uid'];

        $oid = $row['oid'];

        $ono = $row["ono"];

        $odate = $row["orderdate"];

        $otime = $row["ordertime"];

        $pname = $row['pname'];

        $pimg = $row['pimg'];

        $amount = $row['amount'];

        $orderby = $row['orderby'];

        $iscomplete = $row['iscomplete'];

        $iscancel = $row['iscancel'];

        $status = $row['status'];

        $thisono = $ono;

        $thispname =  $pname;

        $thispimg = $pimg;

        $thisamount = $amount;

        $thisorderby = $orderby;



            $thisono = $ono;

            $thisodate = $odate;

            $thisotime = $otime;

            $thisdate = date_create($thisodate);

            $thisdate = date_format($thisdate, "d-m-Y");

            $thisodatetime = $thisdate . " " . $thisotime;

            $thisamount = '$'.$amount;

           $target = 'images/product-images/'.$thispimg;

          empty($thispimg) ?     $thisimg = ''    :  $thisimg = ' <img src="'.$target.'" alt="">';

         file_exists($target) ? $thisimg = ''     :  $thisimg = '<img src="'.$target.'" alt="">';

          empty($thispname) ?    $thispname= ''  :  $thispname = $thispname;  



        if($iscomplete == 0)

         {

          $thisstatus = '<strong style="color:#4285F4!important;">Pending</strong>';

         }        

        if($iscomplete == 1)

         {

           $thisstatus = '<strong style="color:#089000!important;">Completed</strong>';    

         }

        

        if($iscancel == 1){

         $thisstatus = '<strong style="color:#DB4473!important;">Cancelled</strong>';

        }

        

      

        $paginationHtml .= '<tr>';

        $paginationHtml .= '<td>' . $thisorderby . '</td>';

        $paginationHtml .= '<td>' . $thisodatetime . '</td>';

        $paginationHtml .= '<td>' . $thisono . '</td>';

        $paginationHtml .= '<td>' . $thisimg . '</td>';

        $paginationHtml .= '<td>' . $thispname . '</td>';

        $paginationHtml .= '<td>' . $thisamount . '</td>';

        $paginationHtml .= '<td>' . $thisstatus . '</td>';

        $paginationHtml .= '</tr>';

  

            

 }

}

else

{

    if ($search != '')

    {

        $paginationHtml = '<div class="row"></div><div class="col-sm-12"><strong>There is no orders found of ' . $search . '</strong></div>';

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

