<?php 
$file_name="users";

//Header section
require_once("include/header.php");

$user_id = $post['id'];

if($user_id>0 && $prms_customer_edit!='1') {
	setRedirect(ADMIN_URL.'profile.php');
	exit();
}

//Fetch single user data based user id
$user_data = get_user_data($user_id);
if(empty($user_data)) {
	setRedirect(ADMIN_URL.'users.php');
	exit();
}

//Template file
require_once("views/user/edit_user.php");

//Footer section
include("include/footer.php"); ?>
