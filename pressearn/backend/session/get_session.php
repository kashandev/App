<?php
// include session //
include_once('session.php'); // this is used for include session //
// end of include session //
if(isset($_SESSION['user_id_pk'])==""){
$profile_id="";  
$user_id_pk = "";  
$user_name = "";
$user_email = "";
$user_contact = "";
$user_address = "";
$user_cnic = "";
$user_image_name = "";
$user_image_guid = "";
$user_role = "";
$notification = "";

}
if(isset($_SESSION['user_id_pk'])){
$user_id_pk = $_SESSION['user_id_pk']; 
$user_name = $_SESSION['user_name'];
$user_email = $_SESSION['user_email'];
$user_image_name = $_SESSION['user_image_name'];
$user_image_guid = $_SESSION['user_image_guid'];
$user_role = $_SESSION['user_role'];
}

?>

