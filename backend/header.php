<?php

// include session //

include_once ('session/get_session.php'); // this is used for include get session //

// end of include session //



// include conn //

include_once ('conn/config.php'); // this is used for include conn //

// end of include conn //



   $now = '';

   // set date function //

   $now = date('Y');

   // end of set date function //

  if (isset($_SESSION['user_id_pk'])) {

       $user_id_pk = $_SESSION['user_id_pk'];

       $user_name  = $_SESSION['user_name'];

       $user_role  = $_SESSION['user_role'];

   } else {

       echo "<script>location.assign('index.php')</script>";

   }



if (isset($_SESSION['user_company_id']) == "") {

    $_SESSION['user_company_id'] = "";

}

if (isset($_SESSION['user_company_id'])) {

    $user_company_id = $_SESSION['user_company_id'];

}



if (isset($_SESSION['welcome_message']) == "") {

    $welcome_message = "";

}



if (isset($_SESSION['welcome_message'])) {

    $welcome_message = $_SESSION['welcome_message'];

}



function unset_session()

{

    unset($_SESSION['welcome_message']);

}

?>

<!-- html -->   

<!DOCTYPE html>

<html>

   <!-- header -->  

   <head>

      <!-- Meta UTF-8 --> 

      <meta charset="utf-8">

      <!-- /.Meta UTF-8 --> 

      <!-- Meta Device Width -->    

      <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>

      <meta http-equiv="Content-Security-Policy" content="upgrade-insecure-requests" />

      <!-- /.Meta Device Width -->   

      <!-- Css Links -->

      <link href="public/css/bootstrap.css" rel="stylesheet" type="text/css" />

      <link href="public/css/bootstrap.min.css" rel="stylesheet" type="text/css" />

      <link href="public/css/main-style.css" rel="stylesheet" type="text/css" />

      <link rel="stylesheet" href="public/css/bootstrap-switch.css" rel="stylesheet" type="text/css">

      <link href="public/css/wysiwyg.css" rel="stylesheet">

      <link href="public/css/font-awesome.min.css" rel="stylesheet" type="text/css" />

      <link href="http://code.ionicframework.com/ionicons/2.0.0/css/ionicons.min.css" rel="stylesheet" type="text/css" />

      <link href="public/admin/plugins/datatables/dataTables.bootstrap.css" rel="stylesheet" type="text/css" />

      <link href="public/admin/dist/css/AdminLTE.min.css" rel="stylesheet" type="text/css" />

      <link href="public/admin/dist/css/skins/_all-skins.min.css" rel="stylesheet" type="text/css" />

      <link href="public/admin/plugins/fullcalendar/fullcalendar.min.css" rel="stylesheet" type="text/css" />

      <link href="public/admin/plugins/fullcalendar/fullcalendar.print.css" rel="stylesheet" type="text/css" />

      <link href="public/admin/plugins/bootstrap-select/bootstrap-select.min.css" rel="stylesheet" type="text/css" />

      <link href="public/css/datepicker.css" rel="stylesheet" type="text/css" />

      <link href="public/admin/dist/css/skins/nas.css" rel="stylesheet" type="text/css" />

      <link href="public/css/custom.css" rel="stylesheet" type="text/css" />

      <link rel="stylesheet" href="public/css/radio.css" rel="stylesheet" type="text/css">

      <link rel="stylesheet" href="public/css/modal.css" rel="stylesheet" type="text/css">

      <link rel="stylesheet" href="public/css/nav.css" rel="stylesheet" type="text/css">
      
      <link rel="stylesheet" href="public/css/pangination.css" rel="stylesheet" type="text/css">

      <!-- /.Css Links -->

      <title>Main Panel</title>

   </head>

   <!-- /.header -->

