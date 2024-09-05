<?php
// get session //
// include session //
include_once('session.php'); // this is used for include session //
// end of include session //
if (isset($_SESSION['u_id_pk']) == "") {
	$profile_id = "";
	$u_id_pk = "";
	$u_inv_id = "";
	$ref_code = "";
	$my_ref_code = "";
	$u_name = "";
	$u_email = "";
	$u_image_name = "";
	$u_image_guid = "";
	$u_role = "";
	$u_inv_id = "";
	$u_tm_id = "";
	$ref_code = "";
	$notification = "";
	$thisimage = '';
}
if (isset($_SESSION['login_id']) == '') {
	$_SESSION['login_id'] = "";
}
if (isset($_SESSION['u_inv_id']) == '') {
	$_SESSION['u_inv_id'] = "";
}
if (isset($_SESSION['u_tm_id']) == '') {
	$_SESSION['u_tm_id'] = "";
}

if (isset($_SESSION['u_name']) == '') {
	$_SESSION['u_name'] = "";
}
if (isset($_SESSION['u_email']) == '') {
	$_SESSION['u_email'] = "";
}

if (isset($_SESSION['u_image_name']) == '') {
	$_SESSION['u_image_name'] = "";
}

if (isset($_SESSION['u_image_guid']) == '') {
	$_SESSION['u_image_guid'] = "";
}

if (isset($_SESSION['u_role']) == '') {
	$_SESSION['u_role'] = "";
}
if (isset($_SESSION['u_id_pk'])) {
	$thisimage = '';
	$u_id_pk = $_SESSION['u_id_pk'];
	$u_inv_id = $_SESSION['u_inv_id'];
	$u_tm_id = $_SESSION['u_tm_id'];
	$ref_code = $_SESSION['ref_code'];
	$my_ref_code = $_SESSION['my_ref_code'];
	$u_name = $_SESSION['u_name'];
	$u_email = $_SESSION['u_email'];
	$u_image_name = $_SESSION['u_image_name'];
	$u_image_guid = $_SESSION['u_image_guid'];
	$u_role = $_SESSION['u_role'];
	if (file_exists('images/' . $u_image_guid)) {
		$thisimage = '<img src="images/' . $u_image_guid . '" alt="User Profile" class="img-responsive img-circle profileimg">';
	} else {
		$thisimage = '<img src="images/profile/' . $u_image_guid . '" alt="User Profile" class="img-responsive img-circle profileimg" style="width: 150px;height: 150px;">';
	}
}

