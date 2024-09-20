<?php
   // include session //
   
   include_once ('session/get_session.php'); // this is used for include get session //
   
   // end of include session //
   
      $now = '';
   
      // set time zone //
   
      date_default_timezone_set('Asia/karachi');
   
      // end of set time zone //
   
      // set date function //
   
      $now = date('Y');
   
      // end of set date function //
   
   
   
   $encryption_key = '';
   
   $login_txt = "";
   
   $this_form = "";
   
   $this_message = "";
   
   $this_signout_msg = "";
   
   $login_txt = "Admin Login";
   
   
   
   if(isset($_GET['login_id']) == ""){
   
    $_GET['login_id'] = "";
   
   }
   
   
   
   if(isset($_GET['login_id'])){
   
   $login_id = $_GET['login_id'];
   
   }
   
   
   
   if(isset($_SESSION['user_id_pk'])){
   
   echo "<script>location.assign('dashboard.php')</script>";
   
   }
   
   
   
   if(isset($_SESSION['signout_message']) == ""){
   
   $signout_message = "";
   
   }
   
   
   
   if(isset($_SESSION['signout_message'])){
   
   $signout_message = $_SESSION['signout_message'];
   
   }
   
   
   
   function unset_session(){
   
     unset($_SESSION['signout_message']);
   
   }
   
   ?>
<!DOCTYPE html>
<html lang="en">
   <head>
      <meta charset="UTF-8">
      <meta http-equiv="X-UA-Compatible" content="IE=edge">
      <meta name="viewport" content="width=device-width, initial-scale=1.0">
      <title>Login</title>
      <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
      <!-- Bootstrap CSS -->
      <!-- Font Awesome for Icons -->
      <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
      <!-- loginstyle -->
      <link rel="stylesheet" href="public/css/login.css">
   </head>