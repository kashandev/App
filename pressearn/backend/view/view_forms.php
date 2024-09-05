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
$paymentmethod = '';
$thislabel = '';
$paginationCtrls = '';
$thisregno = '';
$thisname = '';
$thisfname = '';
$thiscnic = '';
$thisprovince = '';
$thisresadd = '';
$thisoffadd = '';
$thisemail = '';
$thisphone = '';
$thiswhats = '';
$thiskin = '';
$thisnom = '';
$thisnomcnic = '';
$thisrelation = '';
$thishref = '';
$thismsglabel = '';
$thisheading = '';
// end of variables //
if (isset($_POST['page']))
{
    $page = $_POST['page'];
}

if (isset($_POST['paymentmethod']))
{
    $paymentmethod = $_POST['paymentmethod'];
}

if (isset($_POST['search']))
{
    $search = $_POST['search'];
}

if ($paymentmethod == 'all' && $search == '' || $search != '')
{
    $all_qry = "SELECT * from forms_master";
    $thismsglabel = 'Sorry no results found';
    $thisheading = 'View Forms';

}
if ($paymentmethod == 'bank' && $search == '' || $search != '')
{
    $all_qry = "SELECT * from forms_master where pmethod = '" . $paymentmethod . "' ";
    $thismsglabel = 'Sorry no results found of Bank Transfer';
    $thisheading = 'Bank Transfer';

}
if ($paymentmethod == 'easy' && $search == '' || $search != '')
{
    $all_qry = "SELECT * from forms_master where pmethod = '" . $paymentmethod . "'";
    $thismsglabel = 'Sorry no results found of Easypaisa';
    $thisheading = 'Easypaisa';

}
if ($paymentmethod == 'jazz' && $search == '' || $search != '')
{
    $all_qry = "SELECT * from forms_master where pmethod = '" . $paymentmethod . "' ";
    $thismsglabel = 'Sorry no results found of Jazz Cash';
    $thisheading = 'Jazz Cash';

}
if ($paymentmethod == 'all' && $search != '')
{
    $all_qry = "SELECT * from forms_master where fullname = '" . $search . "' ";

}
if ($paymentmethod == 'bank' && $search != '')
{
    $all_qry = "SELECT * from forms_master where pmethod = '" . $paymentmethod . "' and forms_master.fullname = '" . $search . "' ";

}
if ($paymentmethod == 'easy' && $search != '')
{
    $all_qry = "SELECT * from forms_master where pmethod = '" . $paymentmethod . "' and forms_master.fullname = '" . $search . "' ";

}
if ($paymentmethod == 'jazz' && $search != '')
{
    $all_qry = "SELECT * from forms_master where pmethod = '" . $paymentmethod . "' and forms_master.fullname = '" . $search . "' ";

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

if ($paymentmethod == 'all' && $search == '' || $search != '')
{
    $all_qry = "SELECT * from forms_master $limit";
    $thismsglabel = 'Sorry no results found';
    $thisheading = 'View Forms';

}
if ($paymentmethod == 'bank' && $search == '' || $search != '')
{
    $all_qry = "SELECT * from forms_master where pmethod = '" . $paymentmethod . "' $limit ";

}
if ($paymentmethod == 'easy' && $search == '' || $search != '')
{
    $all_qry = "SELECT * from forms_master where pmethod = '" . $paymentmethod . "' $limit ";

}
if ($paymentmethod == 'jazz' && $search == '' || $search != '')
{
    $all_qry = "SELECT * from forms_master where pmethod = '" . $paymentmethod . "' $limit ";

}
if ($paymentmethod == 'all' && $search != '')
{
    $all_qry = "SELECT * from forms_master where fullname = '" . $search . "' $limit ";
}
if ($paymentmethod == 'bank' && $search != '')
{
    $all_qry = "SELECT * from forms_master where pmethod = '" . $paymentmethod . "' and forms_master.fullname = '" . $search . "' $limit ";
    $thismsglabel = 'Sorry no results found of Bank Transfer';

}
if ($paymentmethod == 'easy' && $search != '')
{
    $all_qry = "SELECT * from forms_master where pmethod = '" . $paymentmethod . "' and forms_master.fullname = '" . $search . "' $limit ";
    $thismsglabel = 'Sorry no results found of Easypaisa';

}
if ($paymentmethod == 'jazz' && $search != '')
{
    $all_qry = "SELECT * from forms_master where pmethod = '" . $paymentmethod . "' and forms_master.fullname = '" . $search . "' $limit";
    $thismsglabel = 'Sorry no results found for Jazz Cash';

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
                        <table class="table table-striped table-bordered easy-table" id="table">   
                                    <thead>
                                       <tr>
                                         <th>SNo</th>
                                          <th>Reg No</th>
                                          <th>Full Name</th>
                                          <th>Father's Name</th>
                                          <th>CNIC/NICOP</th>
                                          <th>Address</th>
                                          <th>Province</th>
                                          <th>Email address</th>
                                          <th>Mobile Number</th>
                                          <th>Whatsapp Number</th>
                                          <th>Nominee</th>
                                          <th>CNIC(Nominee)</th>
                                          <th>Relation</th>

                                       </tr>
                                    </thead>
                                    <tbody>
       
   
   <?php
    foreach ($sql as $key => $row)
    {
        $key++;
        $fmid = $row['fmid'];
        $regno = $row['regno'];
        $fullname = $row['fullname'];
        $fname = $row['fathersname'];
        $cnic = $row['cnic'];
        $resaddress = $row['resaddress'];
        $province = $row['province'];
        $offaddress = $row['offaddress'];
        $email = $row['email'];
        $phone = $row['phone'];
        $whatsappno = $row['whatsappno'];
        $kin = $row['kin'];
        $nom = $row['nom'];
        $nomcnic = $row['nomcnic'];
        $relation = $row['relation'];

        $thisregno = $regno;
        $thisname = $fullname;
        $thisfname = $fname;
        $thiscnic = $cnic;
        $thisprovince = $province;
        $thisphone = $phone;
        empty($resaddress) ? $thisresadd = 'null' : $thisresadd = $resaddress;
        empty($offaddress) ? $thisoffadd = 'null' : $thisoffadd = $offaddress;
        empty($email) ? $thisoffadd = 'null' : $thisemail = $email;
        empty($whatsappno) ? $thiswhats = 'null' : $thiswhats = $whatsappno;
        empty($kin) ? $thiskin = 'null' : $thiskin = $kin;
        empty($nom) ? $thisnom = 'null' : $thisnom = $nom;
        empty($nomcnic) ? $thisnomcnic = 'null' : $thisnomcnic = $nomcnic;
        empty($relation) ? $thisrelation = 'null' : $thisrelation = $relation;

        $thishref = '<a href="view/view.php?id=' . $fmid . '">' . $thisname . '</a>';

        $paginationHtml .= '<tr>';
        $paginationHtml .= '<td>' . $key . '</td>';
        $paginationHtml .= '<td>' . $thisregno . '</td>';
        $paginationHtml .= '<td>' . $thishref . '</td>';
        $paginationHtml .= '<td>' . $thisfname . '</td>';
        $paginationHtml .= '<td>' . $thiscnic . '</td>';
        $paginationHtml .= '<td>' . $thisresadd . '</td>';
        $paginationHtml .= '<td>' . $thisprovince . '</td>';
        $paginationHtml .= '<td>' . $thisemail . '</td>';
        $paginationHtml .= '<td>' . $thisphone . '</td>';
        $paginationHtml .= '<td>' . $thiswhats . '</td>';
        $paginationHtml .= '<td>' . $thisnom . '</td>';
        $paginationHtml .= '<td>' . $thisnomcnic . '</td>';
        $paginationHtml .= '<td>' . $thisrelation . '</td>';
        $paginationHtml .= '</tr>';
    }
}
else
{
    if ($search != '')
    {
        $paginationHtml = '<div class="row"></div><div class="col-sm-12"><div class="alert alert-danger"><strong>Sorry no results found of ' . $search . '</strong></div></div>';
    }
    else
    {
        $paginationHtml = '<div class="row"></div><div class="col-sm-12"><div class="alert alert-danger"><strong>' . $thismsglabel . '</strong></div></div>';
    }
    $paginationCtrls = '';
}
echo $paginationHtml;
?>
</tbody>
</table>
<div id="pagination" class="pagination"><?php echo $paginationCtrls; ?></div>
 </div>
