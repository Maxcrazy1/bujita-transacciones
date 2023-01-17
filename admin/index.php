<?php
//Header section
require_once("include/login/header.php");

//If already logged in then it will redirect to profile page
if(!empty($_SESSION['is_admin']) && $_SESSION['admin_username']!="") {
	setRedirect(ADMIN_URL.'profile.php');
	exit();
}

//Template file
require_once("views/admin_user/login.php");

//Footer section
require_once("include/login/footer.php"); ?>
