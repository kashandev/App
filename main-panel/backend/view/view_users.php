<?php

// include session //

include_once ('../session/session.php'); // this is used for include session //

// end of include session //

// include conn //

include_once ('../conn/config.php'); // this is used for include conn //

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

$thisrole = '';

$thisrefcode = '';

$thiuname = '';

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

$thischeckaction = "";

$thisaction = "";

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



    $all_qry = "SELECT users.*,roles.* from users inner join roles on roles.roleid = users.roleid 

    where users.isdeleted = 0 and roles.role not in('superadmin') order by userid desc";

    $thismsglabel = 'There is no all users found';

    $thisheading = 'All Users';

}

if ($type == 'new' && $search == '' || $search != '')

{

    $all_qry = "SELECT users.*,roles.* from users inner join roles on roles.roleid = users.roleid where users.status = '" . $type . "' and users.isdeleted = 0 and users.isnew = 1 and roles.role not in('superadmin') order by userid desc";

    $thismsglabel = 'There is no new users found';

    $thisheading = 'New Users';

}



if ($type == 'top' && $search == '' || $search != '')

{

    $all_qry = "SELECT users.*,roles.* from users inner join roles on roles.roleid = users.roleid where users.status = '" . $type . "' and users.isdeleted =0 and users.istop = 1 and roles.role not in('superadmin','admin','agent') order by userid desc";

    $thismsglabel = 'There is no top users found';

    $thisheading = 'Top Users';



}

if ($type == 'block' && $search == '' || $search != '')

{

    $all_qry = "SELECT users.*,roles.* from users inner join roles on roles.roleid = users.roleid where users.isdeleted = 1 and users.isblock = 1 and roles.role not in('superadmin') order by userid desc";

    $thismsglabel = 'There is no blacklisted users found';

    $thisheading = 'Blacklist Users';



}

if ($type == 'deleted' && $search == '' || $search != '')

{

    $all_qry = "SELECT users.*,roles.* from users inner join roles on roles.roleid = users.roleid where users.isdeleted = 1 and users.isblock = 0 and roles.role not in('superadmin') order by userid desc";

    $thismsglabel = 'There is no deleted users found';

    $thisheading = 'Deleted Users';

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

    $all_qry = "SELECT users.*,roles.* from users inner join roles on roles.roleid = users.roleid 

    where users.isdeleted = 0 and roles.role not in('superadmin') order by userid desc $limit";

    $thismsglabel = 'Sorry no results found';

    $thisheading = 'All Users';



}

if ($type == 'new' && $search == '' || $search != '')

{

    $all_qry = "SELECT users.*,roles.* from users inner join roles on roles.roleid = users.roleid  where users.status = '" . $type . "' and users.isdeleted = 0 and users.isnew = 1 and roles.role not in('superadmin') order by userid desc $limit ";

    $thismsglabel = 'There is no new users found';

        $thisheading = 'New Users';

}





if ($type == 'top' && $search == '' || $search != '')

{

    $all_qry = "SELECT users.*,roles.* from users inner join roles on roles.roleid = users.roleid where users.status = '" . $type . "' and users.isdeleted = 0 and users.istop = 1 and roles.role not in('superadmin','admin','agent') order by userid desc $limit ";

   $thismsglabel = 'There is no top users found';

     $thisheading = 'Top Users';

}



if ($type == 'block' && $search == '' || $search != '')

{

    $all_qry = "SELECT users.*,roles.* from users inner join roles on roles.roleid = users.roleid where users.isdeleted = 1 and users.isblock = 1 and roles.role not in('superadmin') order by userid desc $limit";

    $thismsglabel = 'There is no blacklisted users found';

    $thisheading = 'Blacklisted Users';



}

if ($type == 'deleted' && $search == '' || $search != '')

{

    $all_qry = "SELECT users.*,roles.* from users inner join roles on roles.roleid = users.roleid where users.isdeleted = 1 and users.isblock = 0 and roles.role not in('superadmin') order by userid desc $limit";

    $thismsglabel = 'There is no deleted users found';

    $thisheading = 'Deleted Users';

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



             <?php if ($type == "all" || $type == 'new' ) { ?>



                         <div class="row" id="button-div">  

                        <div class="col-sm-8"><button type="button" class="btn btn-primary btn-delete" disabled=""><i class="fa fa-trash"> </i>  Delete </button> <button type="button" class="btn btn-primary btn-bl-list" disabled=""><i class="fa fa-ban"> </i>  Blacklist </button> <button type="button" id="checkAll" class="main btn btn-primary btn-check"> <span class="sub"></span> <i class="fa fa-check"> </i> Check </button> <button type="button" id="uncheckAll" class="main btn btn-primary btn-uncheck"> <span class="sub"></span> <i class="fa fa-check"> </i> UnCheck </button>

                      </div>

                    </div>

                    

                    <?php } elseif ($type == "deleted") { ?>



                         <div class="row" id="button-div">  

                        <div class="col-sm-8"> <button type="button" class="btn btn-primary btn-restore" disabled=""> <i class="fa fa-undo"> </i> Restore </button> <button type="button" id="checkAll" class="main btn btn-primary btn-check-r"> <span class="sub"></span> <i class="fa fa-check"> </i> Check </button> <button type="button" id="uncheckAll" class="main btn btn-primary btn-uncheck-r"> <span class="sub"></span> <i class="fa fa-check"> </i> UnCheck </button>

                      </div>

                    </div>

                    

                    <?php } elseif ($type == "block") { ?>



                      <div class="row" id="button-div">  

                        <div class="col-sm-8"> <button type="button" class="btn btn-primary btn-restore-bl" disabled=""> <i class="fa fa-undo"> </i> Restore </button> <button type="button" id="checkAll" class="main btn btn-primary btn-check-r-bl"> <span class="sub"></span> <i class="fa fa-check"> </i> Check </button> <button type="button" id="uncheckAll" class="main btn btn-primary btn-uncheck-r-bl"> <span class="sub"></span> <i class="fa fa-check"> </i> UnCheck </button>

                      </div>

                    </div>



                   <?php } ?>

<table class="table table-striped table-bordered users-table" id="table">   

<?php if ($type == "all" || $type == "new") { ?>

                                    <thead>

                                       <tr>

                                          <th>Check</th>

                                          <th>Role</th>

                                          <th>User Name</th>

                                          <th>Ref Code</th>

                                          <th>Email</th>

                                          <th>Mobile No</th>

                                          <th>Country</th>

                                          <th>Status</th>

<!--                                           <th>Action</th>  -->

                                       </tr>

                                    </thead>



                                <?php } elseif ($type == "deleted" || $type == "block") { ?>

                                    <thead>

                                       <tr>

                                          <th>Check</th>

                                          <th>Role</th>

                                          <th>User Name</th>

                                          <th>Ref Code</th>

                                          <th>Email</th>

                                          <th>Mobile No</th>

                                          <th>Country</th>

                                          <th>Status</th>

                                       </tr>

                                    </thead>

                                <?php } ?>



                                    <tbody>

       

   

   <?php

    foreach ($sql as $key => $row)

    {

        $key++;

        $userid = $row['userid'];

        $role = $row['role'];

        $refcode = $row['refcode'];

        $uname = $row['uname'];

        $email = $row['email'];

        $mobile = $row['mobile'];

        $country = $row['country'];

        $ccode = $row['ccode'];

        $isdeleted = $row["isdeleted"];

        $isedit = $row["isedit"];

        $isblock = $row["isblock"];

        $isrestore = $row["isrestore"];

        $status = $row['status'];

        $createdate = $row['createdate'];

        $thisrole = $role;

        $thisrefcode = $refcode;

        $thiuname = $uname;

        $thisccode = $ccode;

        $thismobile = $mobile;

        $thiscountry = $country;

   if ($isdeleted == 0) {

           $thisstatus =

               '<strong style="color:#4285F4!important;">New</strong>';

           $thischeckaction =

               '<input type="checkbox" class="uid" name="uid[]" id="uid' .

               $userid .

               '" data-id=' .

               $key .

               ' value="' .

               $userid .

               '"/>';

           $thisaction =

               '<span style="color:#089000!important; cursor:pointer;" class="btn-search" data-id="' .

               $userid .

               '"> Update <i class="fa fa-pencil"></i></span>';

       }

       if ($isdeleted == 1) {

           $thisstatus =

               '<strong style="color:#DB4473!important;">Deleted</strong>';

           $thischeckaction =

               '<input type="checkbox" class="duid" name="duid[]" id="dwaid' .

               $userid .

               '" data-id=' .

               $key .

               ' value="' .

               $userid .

               '"/>';

       }if ($isblock == 1) {

           $thisstatus =

               '<strong style="color:#DB4473!important;">Blocked</strong>';

           $thischeckaction =

               '<input type="checkbox" class="buid" name="buid[]" id="bwaid' .

               $userid .

               '" data-id=' .

               $key .

               ' value="' .

               $userid .

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

        empty($email) ? $thisemail = 'null' : $thisemail = $email;

 

         $thishref = '<a href="">' . $thiuname . '</a>';



    if ($type == "all" || $type == "new") {

        $paginationHtml .= "<tr>";

        $paginationHtml .= "<td>" . $thischeckaction . "</td>";

        $paginationHtml .= '<td>' . $thisrole . '</td>';

        $paginationHtml .= '<td>' . $thishref . '</td>';

        $paginationHtml .= '<td>' . $thisrefcode . '</td>';

        $paginationHtml .= '<td>' . $thisemail . '</td>';

        $paginationHtml .= '<td>' . $thismobile . '</td>';

        $paginationHtml .= '<td>' . $thiscountry . '</td>';

        $paginationHtml .= '<td>' . $thisstatus . '</td>';

        // $paginationHtml .= "<td>" . $thisaction . "</td>";

        $paginationHtml .= '</tr>';



       }elseif ($type == "deleted") {

        $paginationHtml .= "<tr>";

        $paginationHtml .= "<td>" . $thischeckaction . "</td>";

        $paginationHtml .= '<td>' . $thisrole . '</td>';

        $paginationHtml .= '<td>' . $thishref . '</td>';

        $paginationHtml .= '<td>' . $thisrefcode . '</td>';

        $paginationHtml .= '<td>' . $thisemail . '</td>';

        $paginationHtml .= '<td>' . $thismobile . '</td>';

        $paginationHtml .= '<td>' . $thiscountry . '</td>';

        $paginationHtml .= '<td>' . $thisstatus . '</td>';

        $paginationHtml .= '</tr>';

       }elseif ($type == "block") {

        $paginationHtml .= "<tr>";

        $paginationHtml .= "<td>" . $thischeckaction . "</td>";

        $paginationHtml .= '<td>' . $thisrole . '</td>';

        $paginationHtml .= '<td>' . $thishref . '</td>';

        $paginationHtml .= '<td>' . $thisrefcode . '</td>';

        $paginationHtml .= '<td>' . $thisemail . '</td>';

        $paginationHtml .= '<td>' . $thismobile . '</td>';

        $paginationHtml .= '<td>' . $thiscountry . '</td>';

        $paginationHtml .= '<td>' . $thisstatus . '</td>';

        $paginationHtml .= '</tr>';



       }

    }

}

else

{

    if ($search != '')

    {

        $paginationHtml = '<div class="row"></div><div class="col-sm-12"><strong>There is no user found of ' . $search . '</strong></div>';

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

