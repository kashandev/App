<?php
// include session //
include_once 'session/get_session.php'; // this is used for include get session //
// end of include session //
// include conn //
include_once 'conn/conn.php'; // this is used for include conn //
// end of include conn //
$now = '';
// set date function //
$now = date('Y');
// end of set date function //
$thisturl = '';
$thisdurl = '';
$thiswurl = '';

if (isset($_SESSION['u_id_pk'])) {
    $u_id_pk = $_SESSION['u_id_pk'];
    $u_name = $_SESSION['u_name'];
    $u_role = $_SESSION['u_role'];
    $thisturl = 'topup-method.php';
    $thiswurl = 'withdrawal.php';
    $thisdurl = 'deposit.php';
} else {
    $thisturl = 'signin.php';
    $thisdurl = 'signin.php';
    $thiswurl = 'signin.php';
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

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" ></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js" ></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js" ></script>
    <link rel="stylesheet" type="text/css" href="//cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.css"/>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/js/bootstrap.min.js"></script>
    <!-- my css -->
  <link href='https://fonts.googleapis.com/css?family=Slackey' rel='stylesheet' type='text/css'/>
  <link type="text/css" rel="stylesheet" href="css/reset.css" />
  <link type="text/css" rel="stylesheet" href="css/slot.css" />
  <link rel="stylesheet" href="css/deposit.css">
  <link rel="stylesheet" href="css/style.css">
</head>
